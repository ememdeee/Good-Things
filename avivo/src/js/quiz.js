var $ = $ || jQuery;

// @prepros-prepend "plugins/js.cookie.min.js";
// @prepros-prepend "plugins/handlebars.min.js";

window.GlobalQuiz = {
  cookieName: 'journey-quiz',
  getSavedData: function () {
    return Cookies.getJSON(this.cookieName) || {};
  }
};


// assistants
function Assistant(id) {
  var defaults = {
    stepActiveClass: 'quiz-step--active',
    stepDeactivatingClass: 'quiz-step--deactivating',
    cookieName: window.GlobalQuiz.cookieName,
  };

  var selectors = {
    fitOptionsTemplate: '#FitOptionsTemplate',
    fitBottomNavTemplate: '#FitBottomNavTemplate'
  };

  this.id = id;
  this.$el = $('#' + id);
  this.$steps = this.$el.find('.quiz__step');
  // this.currentStepId = null;
  this.stepStackId = [];

  this.config = defaults;
  this.fields = {};

  // savedData = model
  this.savedData = Cookies.getJSON(this.config.cookieName) || {};
  // console.log('DEBUG, saved data', this.savedData);

  this.resultId = null;

  // console.log('DEBUG, json data', quizData);
  this.data = window.quizData;
  this.numOfSteps = this.data.numberOfSteps || 0;
  this.init();

  // this.stepStackId.push(this.data.firstStep);
  this.stepStackId.push(this.data.initialStep);
  this.gotoStep(this.data.initialStep);

  this.bindEvents();


  // jump to last step where user left off
  // this is dirty hack implementation
  var urlParams = new URLSearchParams(window.location.search);
  if (Object.keys(this.savedData).length > 1 && urlParams.has('result') && urlParams.get('result') === 'true') {
    console.log('DEBUG: continue progress', this.fields);
    // track progress
    let currentStepId = this.getCurrentStepId();
    let that = this;

    let currentStepObj = {
      step: currentStepId,
    }

    let result = false;
    let lastStep = false;

    let trackNext = function(currentStepObj) {
      let currentStepId = currentStepObj.step;
      console.log('DEBUG: current step', currentStepId, that.data);

      if (!that.data.steps[currentStepId]) {
        console.log('DEBUG: last here', currentStepObj);
        result = currentStepObj.result;
        lastStep = currentStepObj.step;
        return false;
      }
      
      let targetFunction = that.data.steps[currentStepId].next;      
      
      console.log('DEBUG: next step', targetFunction, typeof targetFunction === 'function');
      let targetStep = targetFunction(that.fields);
      console.log('DEBUG: next step', targetStep);  

      if (targetStep.error) {
        lastStep = currentStepId;
        return false;
      }
      
      return trackNext(targetStep);
    }

    let nextStep = trackNext(currentStepObj);
    console.log('DEBUG: next step', nextStep);
    console.log('DEBUG: last step', lastStep);
    console.log('DEBUG: result', result);

    
    // load step stacks
    if (this.savedData['steps-stack']) {
      this.stepStackId = this.savedData['steps-stack'];

      let lastStepStack = this.stepStackId[this.stepStackId.length - 1];
      let that = this;

      if (lastStepStack === 'result' && result && lastStep === 'result') {
        // jump to result
            // this.gotoStep('result');
            console.log('DEBUG: go to result', result);
    
            let resultData = this.data.results[result];
            console.log('DEBUG: result data', resultData);
            if (resultData.redirect) {
              // // setTimeout(function() {
              //   window.location = resultData.redirect;
              // // },500);
              alert('You will be redirected to: ' + resultData.redirect);
              
            }          

      } else {
        // jump to step
        console.log('DEBUG: last step', lastStepStack);
        // goto step
        window.setTimeout(function(){
          console.log('DEBUG: go to last step', lastStepStack);
          that.gotoStep(lastStepStack);
        },1200);
  
      }
    }


    // if (lastStep && lastStep !== 'intro') {
    //   if (lastStep === 'result' && result) {
    //     // this.gotoStep('result');
    //     console.log('DEBUG: go to result', result);

    //     let resultData = this.data.results[result];
    //     console.log('DEBUG: result data', resultData);
    //     if (resultData.redirect) {
    //       // setTimeout(function() {
    //         window.location = resultData.redirect;
    //       // },500);
          
    //     }
      
    //   } else {
    //     // this.gotoStep(lastStep);
    //   }  
    // }

  }   

}

Assistant.prototype.init = function () {

                                //   <div class="quiz__step" id="skin-type"  data-valid="false" data-nav='<?php echo json_encode($fit_nav_skin_type); ?>'>

                                //     <div class="quiz__step-header">
                                //         <h4 class="Heading u-h2">
                                //             How would you best describe your skin?
                                //         </h4>     
                                //         <p>Choose One</p>                           
                                //     </div>

                                //     <div class="quiz__content">
                                //         <div class="quiz__question">
                                //             <div class="quiz__options quiz__options--images" data-options-model="skin-type" data-options-question="Skin Type">
                                                                                    
                                //             </div>                            
                                //         </div>
                                //     </div>

                                //     <div class="quiz__step-bottom-nav"></div>

                                // </div>
    var stepsHtml = [];

    // loop this.data's object
    for (var key in this.data.steps) {
      if (this.data.steps.hasOwnProperty(key)) {
        var stepHtml = '';
        var stepData = this.data.steps[key];
        stepData.id = key;
        stepHtml = this.buildStepFieldsAndHtml(stepData);
        // console.log('DEBUG: step html', stepHtml);
        stepsHtml.push(stepHtml);
      }
    }

    // console.log('DEBUG: steps html', stepsHtml);
    this.$el.find('.quiz__steps').html(stepsHtml.join(''));

    this.$el.find('.quiz__result').html(this.buildResultHtml());

    // console.log('DEBUG: fields', this.fields);

    // if this page has querystring restart=true
    var urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('restart') && urlParams.get('restart') === 'true') {
      this.resetData();
    }   

    // load selection based on savedData
    for (var key in this.savedData) {
      if (this.savedData.hasOwnProperty(key) && key !== 'steps-stack') {
        var value = this.savedData[key];
        if (!this.fields[key]) {
          continue;
        }
        this.fields[key].value = value;
        if (value) {
          console.log('DEBUG: saved data', key, value);
          if (this.fields[key].type === 'radio') {
            console.log('DEBUG: target', this.$el.find('.quiz-field input[name="' + key + '"][value="' + value + '"]'));
            this.$el.find('.quiz-field input[name="' + key + '"][value="' + value + '"]').prop('checked', true);
          } else if (this.fields[key].type === 'multiselect') {
            console.log('DEBUG: target', this.$el.find('.quiz-field input[name="' + key + '"][value="' + value + '"]'));
            for (var i = 0; i < value.length; i++) {
              this.$el.find('.quiz-field input[name="' + key + '"][value="' + value[i] + '"]').prop('checked', true);
            }
          }
  
        }
      }    
    }    

    // intro, move quiz-intro-sections to intro step
    $('.quiz-intro-sections').appendTo(this.$el.find('.quiz-step#intro .quiz-step__content .quiz-step__content-inner'));

};

Assistant.prototype.buildStepFieldsAndHtml = function (stepData) {
  // console.log('DEBUG: step data', stepData);
  var html = '';
  var title =  /*stepData.id + ' - ' +*/ stepData.title;
  var description = stepData.description;
  var fields = stepData.fields;
  let stepCustomClass = (stepData.customClass)? ''+stepData.customClass :'';

  html += `<div class="quiz-step ${stepCustomClass}" id="${stepData.id}">`;

  html += `<div class="quiz-step__content"><div class="quiz-step__content-inner">`;
  if (stepData.id !== 'intro') {
    let overrideHeaderfn = (stepData.displayFn)? 'data-display-fn-value="'+title+'" data-display-fn-stepid="'+ stepData.id +'"':'';
    html += ` <div class="quiz-step__header h2" ${overrideHeaderfn}>${title}</div>`;
    if (description) {
    html += ` <div class="quiz-step__description">${description}</div>`;
  }
  }

  for (var key in fields) {
    if (fields.hasOwnProperty(key)) {
      let field = fields[key];
      this.fields[key] = {
        value: null,
        type: field.type
      }
      // console.log('DEBUG: field', field);
      let styleAttr = (field.style)? 'data-style="'+field.style+'"':'';
      let hideTitleAttr = (field.hideTitle)? 'data-hide-title="'+field.hideTitle+'"':'';

      // custom class
      let customClass = (field.customClass)? ''+field.customClass :'';

      var overrideTitleFn = (field.displayFn)? 'data-display-fn-value="'+ field.title +'" data-display-fn-stepid="'+stepData.id+'" data-display-fn-id="'+key+'"':'';
      html += `<div class="quiz-field ${customClass}" data-field-id="${key}" ${styleAttr} ${hideTitleAttr}>`;
      html += ` <h4 class="quiz-field__title" ${overrideTitleFn}>${field.title}</h4>`;
      if (field.type === 'radio') {
        let optionsClass = '';
        if (!field.style && field.options.length == 2) {
          optionsClass = 'quiz-field__options--two';
        }
        html += ` <div class="quiz-field__options ${optionsClass}">`;
        for (var i = 0; i < field.options.length; i++) {
          var option = field.options[i];
          var overrideFnAttr = (option.displayFn)? 'data-display-fn-value="'+option.display+'" data-display-fn-stepid="'+stepData.id+'" data-display-fn-id="'+key+'" data-display-fn-index="'+i+'"':'';
          html += ` <div class="quiz-field__option">`;
          html += `   <input type="radio" name="${key}" value="${option.value}" id="${key}-${i}">`;
          html += `   <label for="${key}-${i}" ${overrideFnAttr}>`;
            if (option.icon) {
              html += `   <img src="${option.icon}">`;
            } else if (field.autoIcons) {
              html += `   <img src="/wp-content/themes/avivo/img/journey-icons/${key}-${option.value}.svg">`;
            }
          html += `   <span>${option.display}</span></label>`;
          html += ` </div>`;
        }
        html += ` </div>`;
      } else if (field.type === 'multiselect') {
        html += ` <div class="quiz-field__options">`;
        for (var i = 0; i < field.options.length; i++) {
          var option = field.options[i];
          var overrideFnAttr = (option.displayFn)? 'data-display-fn-value="'+option.display+'" data-display-fn-stepid="'+stepData.id+'" data-display-fn-id="'+key+'" data-display-fn-index="'+i+'"':'';
          html += ` <div class="quiz-field__option">`;
          html += `   <input type="checkbox" name="${key}" value="${option.value}" id="${key}-${i}">`;
          html += `   <label for="${key}-${i}" ${overrideFnAttr}>`;
            if (option.icon) {
              html += `   <img src="${option.icon}">`;
            } else if (field.autoIcons) {
              html += `   <img src="/wp-content/themes/avivo/img/journey-icons/${key}-${option.value}.svg">`;
            }
          html += `   <span>${option.display}</span></label>`;
          html += ` </div>`;
        }
        html += ` </div>`;
      }

      html += `</div>`;
    }
  }

  html+= `</div></div>`;

  if (stepData.id !== 'intro') {
    let progressBar = '';
    let numOfSteps = stepData.stepNumberMax || this.numOfSteps; // num of step can be different depend of steps
    console.log('DEBUG: numOfSteps', numOfSteps, this.numOfSteps);
    for (let k=0; k<numOfSteps; k++) {
      progressBar += `<div class="${k < stepData.stepNumber ? 'active' : ''}"></div>`;
    }
    if (progressBar) {
      progressBar = `<div class="quiz-step__progress-bar">${progressBar}</div>`;
    }

    html += `<div class="quiz-step__nav"> ${progressBar} <button class="quiz-step__prev btn light"><span class="link-text">Back</span></button> <!--<div class="quiz-step__indicator">Step ${stepData.stepNumber} of ${numOfSteps}</div>--> <button class="quiz-step__next btn dark"><span class="link-text">Next</span></button>  </div>`;
  }
  html += `</div>`;
  return html;
}

Assistant.prototype.buildResultHtml = function () {
  var html = '';
  html += `<div class="quiz-result">`;
  html += ` <h4 class="quiz-result__title">Loading Result</h4>`;
  html += `</div>`;
  return html;
}

Assistant.prototype.getCurrentStepId = function () {
  if (this.stepStackId.length) {
    return this.stepStackId[this.stepStackId.length - 1];
  }
  return null;
}

Assistant.prototype.gotoStep = function (id) {
  var $current = this.$el.find('.quiz-step.'+this.config.stepActiveClass);
  $current.addClass(this.config.stepDeactivatingClass);
  $current.removeClass(this.config.stepActiveClass);

  $('body').attr('data-current-step', id);

  // if (id === 'result') {
  //   this.$el.find('.quiz-step').removeClass(this.config.stepActiveClass);
  //   this.$el.find('.quiz-result').addClass('quiz-result--active');
  //   this.buildResult();
  // } else {
    // console.log('DEBUG: go to step', id);
    // this.$el.find('.quiz-step').removeClass(this.config.stepActiveClass);
    // this.$el.find('.quiz-step#' + id).addClass(this.config.stepActiveClass);
    // // this.currentStepId = id;
    // // this.stepStackId.push(id);
    // console.log('DEBUG: step stack', this.stepStackId);  

    var $target = this.$el.find('.quiz-step#' + id);


console.log('DEBUG, id', id);
    if (id === 'result') {
      $target = this.$el.find('.quiz-result');  
    } else {
      // run callback enter
      console.log('DEBUG: on enter, id = ', id, this.data.steps[id]);
      let enterFn = this.data.steps[id].enter;
      if (enterFn && typeof enterFn === 'function') {
        enterFn(this.fields);
      }
      
      // if (this.data.steps[id])
      
      // update display?
      // console.log('DEBUG: try to override display', this.data);
      
      let $headers = $target.find('.quiz-step__header');
      let $titles = $target.find('.quiz-field__title');
      let $options = $target.find('.quiz-field__option label');
      let that = this;

      $headers.each(function() {
        let $this = $(this);
        let stepId = $this.data('display-fn-stepid');
        let value = $this.data('display-fn-value');
        if (stepId) {
          let displayFn = that.data.steps[stepId].displayFn;
          if (displayFn) {
            $this.text(displayFn(value, that.fields));
          }
        }
      });
      $titles.each(function() {
        let $this = $(this);
        let stepId = $this.data('display-fn-stepid');
        let id = $this.data('display-fn-id');
        let value = $this.data('display-fn-value');
        if (stepId) {
          let displayFn = that.data.steps[stepId].fields[id].displayFn;
          if (displayFn) {
            $this.text(displayFn(value, that.fields));
          }
        }
      });
      $options.each(function() {
        let $this = $(this);
        let stepId = $this.data('display-fn-stepid');
        let id = $this.data('display-fn-id');
        let index = $this.data('display-fn-index');
        let value = $this.data('display-fn-value');
        let $option = $this.closest('.quiz-field__option');
        $option.removeClass('hidden');
        if (stepId) {
          let displayFn = that.data.steps[stepId].fields[id].options[index].displayFn;
          if (displayFn) {
            let displayFnValue = displayFn(value, that.fields);
            if (displayFnValue === false) {
              // hide
              $option.addClass('hidden');
            } else { 
              $this.find('span').html(displayFnValue);              
            }
          }
        }
        
        // resetOnEnter
        if (stepId && id) { 
          console.log('DEBUG: reset on enter', stepId, id);
          if (that.data.steps[stepId].fields[id].resetOnEnter) { 
            // alert('DEBUG: reset on enter');
          }
        }
        // if (fields['q3-serviceneed'] && Array.isArray(fields['q3-serviceneed'].value)) {
        //     fields['q3-serviceneed'].value = [];
        // }
        
      });

      // check resetOnEnter
      for (var fieldId in that.data.steps[id].fields) {
        if (that.data.steps[id].fields.hasOwnProperty(fieldId)) {
          let field = that.data.steps[id].fields[fieldId];
          console.log('DEBUG: check rest on enter', field);
          if (field.resetOnEnter) { 
            console.log('DEBUG: RESET enter', field, fieldId, that.fields[fieldId]);      
            // reset values
            if (that.fields[fieldId] && Array.isArray(that.fields[fieldId].value)) { 
              that.fields[fieldId].value = [];
            }
            // reset UI options
            let $resetOptions = $target.find('.quiz-field[data-field-id="' + fieldId + '"] .quiz-field__option input');
            if ($resetOptions.length) { 
              $resetOptions.each(function() {
                $(this).prop('checked', false);
                $(this).trigger('change');
              });              
            }
            
            //
            console.log(that.fields);
          }
        }
      }

    }

    setTimeout(function () {
      $current.hide();
      $target.show();
      $target.css('display', 'flex');
      $current.removeClass(this.config.stepDeactivatingClass);

      if (id === 'result') {
        this.buildResult();
      }

      window.requestAnimationFrame(function () {
        $target.addClass(this.config.stepActiveClass);
      }.bind(this));

    }.bind(this), 300);


    // header nav. todo: better logic
    if (id === 'intro') {
      $('.header-journey__restart, .header-journey__saveexit').hide();
      $('.header-journey__exit').show();
    } else {
      $('.header-journey__restart, .header-journey__saveexit').show();
      $('.header-journey__exit').hide();
    }

  // }
};

Assistant.prototype.validateStep = function (stepId) {
};

Assistant.prototype.buildResult = function () {
  this.saveData();
  // console.log('DEBUG: build result, result = ', this.resultId);

  var resultData = this.data.results[this.resultId];
  // console.log('DEBUG: result data', resultData);
  redirectUrl = null;
  if (resultData.redirectFn && typeof resultData.redirectFn === 'function') {
    redirectUrl = resultData.redirectFn(this.fields);
  } else if (resultData.redirect) {
    redirectUrl = resultData.redirect;
  }

  if (redirectUrl) {
    setTimeout(function() {
      window.location = redirectUrl;
      // alert('You will be redirected to: ' + redirectUrl);
    },500);
  }

};

// target is either next or prev, this function will run target function in step data, then jump
Assistant.prototype.navClick = function(target) {
    // var targetId = $(this).data('href');
    // console.log('DEBUG: step next click');
    // this.gotoStep(targetId);

    var targetFunction;
    var targetStep;

    var currentStepId = this.getCurrentStepId();
    // console.log('DEBUG: current step', currentStepId);

    if (target == 'next') {
      targetFunction = this.data.steps[currentStepId].next;      
    } /*else if (target == 'prev') {
      targetFunction = this.data.steps[this.currentStepId].prev;
    }*/

    // console.log('DEBUG: next step', targetFunction, typeof targetFunction === 'function');

    if (targetFunction && typeof targetFunction === 'function') {
      targetStep = targetFunction(this.fields);

      if (targetStep.error) {
        console.log('DEBUG: error, targetFunction error', targetStep.error);
        alert(targetStep.error);

      } else if (targetStep.step) {
        this.stepStackId.push(targetStep.step);

        if (targetStep.step === 'result' && targetStep.result) {
          this.resultId = targetStep.result;
        }

        this.gotoStep(targetStep.step);  
      }
  
    } else {
      console.log('DEBUG: error, targetFunction not found');
    }

};

Assistant.prototype.bindEvents = function () {
  var that = this;
  this.$el.find('.quiz-step__next').on('click', function (ev) {
    that.navClick('next');
    ev.preventDefault();
  });
  
  this.$el.find('.quiz-step__prev').on('click', function (ev) {
    // that.navClick('prev');
    if (that.stepStackId.length >= 2) {
      that.stepStackId.pop();
      let prevStep = that.stepStackId[that.stepStackId.length - 1]; // Get the new last element    
      that.gotoStep(prevStep);
    }

    ev.preventDefault();
  });

  // intro button
  $('a[href="#journey-quiz-start"]').on('click', function (ev) {
    that.navClick('next');
    ev.preventDefault();
  });
  
  // select and save data radio button
  this.$el.find('.quiz-field input[type="radio"]').on('change', function (ev) {
    var $this = $(this);
    var fieldKey = $this.attr('name');
    var value = $this.val();
    that.fields[fieldKey].value = value;
    
    // that.saveData();
    // console.log('DEBUG: field change', fieldKey, value, that.savedData);
  });

  // select and save data checkbox
  this.$el.find('.quiz-field input[type="checkbox"]').on('change', function (ev) {
    var $this = $(this);
    var fieldKey = $this.attr('name');
    var value = $this.val();
    var checked = $this.prop('checked');
    var savedValue = that.fields[fieldKey].value || [];
    // console.log('DEBUG: that fields', that.fields);
    // console.log('DEBUG: checkbox change', fieldKey, value, checked, savedValue);
    
    // in some case when data type changed from ratio to checkbox, it still saved single data, convert to array
    if (!Array.isArray(savedValue)) {
      // set first value as array
      savedValue = [savedValue];
    }

    // remove first
    var index = savedValue.indexOf(value);
    if (index > -1) {
      savedValue.splice(index, 1);
    }

    if (checked) {
      savedValue.push(value);
    } else {
    }

    that.fields[fieldKey].value = savedValue;
    // console.log('DEBUG: field change', fieldKey, value, savedValue);
  });

  // restart
  $('.header-journey__restart').on('click', function (ev) {
    that.resetData();
    // that.gotoStep(that.data.initialStep);

    // reload page
    location.reload();

    ev.preventDefault();  
  });

  // save
  $('.header-journey__saveexit').on('click', function (ev) {
    that.saveData();
    location.href = '/';
    ev.preventDefault();  
  });
};

Assistant.prototype.saveData = function () {
  // save data from fields. only save value
  // this.resetData();
  this.savedData = {};
  // this.savedData = this.fields;

  for (var key in this.fields) {
    if (this.fields.hasOwnProperty(key)) {
      var field = this.fields[key];
      // if (field.value !== null) {
        this.savedData[key] = field.value;
        // console.log('DEBUG: save data', key, field.value);
      // }
    }
  }

  // ClueEdit: need to jump to last step, where user left off
  // dirty hack with special key named steps-stack
  this.savedData['steps-stack'] = this.stepStackId;

  console.log('DEBUG: data saved', this.savedData);

  Cookies.set(this.config.cookieName, this.savedData, { expires: 3600 }); // very long days
};

Assistant.prototype.resetData = function () {
  // reset savedData
  this.savedData = {};
  Cookies.set(this.config.cookieName, this.savedData, { expires: 3600 }); // very long days
};

Assistant.prototype.unbindEvents = function () {

};


// handlebars helper for conditional
Handlebars.registerHelper('ifeq', function (a, b, options) {
  if (a == b) { return options.fn(this); }
  return options.inverse(this);
});

Handlebars.registerHelper('ifnoteq', function (a, b, options) {
  if (a != b) { return options.fn(this); }
  return options.inverse(this);
});

// var skinQuizAssistant = new Assistant('JourneyQuiz');




function journeyResult() {
  // console.log('DEBUG: Journey Result page');
  var data = window.quizData;
  // console.log('DEBUG: data', data);

  var savedData = Cookies.getJSON(window.GlobalQuiz.cookieName) || {};
  // console.log('DEBUG: saved data', savedData);

  if (!savedData || !Object.keys(savedData).length) {
    // console.log('DEBUG: no saved data');
    return false;
  }
  // 
  
  var allFields = {};
  // loop this.data's object
  for (var key in data.steps) {
    if (data.steps.hasOwnProperty(key)) {
      let stepData = data.steps[key];
      stepData.id = key;
      let fields = stepData.fields;
      console.log('DEBUG: fields', fields);
  
      for (var key in fields) {
        if (fields.hasOwnProperty(key)) {
          var field = fields[key];

          allFields[key] = {
            value: null,
            type: field.type,
            options: field.options,
            title: field.title,
            stepId: stepData.id
          }
          // console.log('DEBUG: field', field);
        }
      }
    }
  }
  
  // console.log('DEBUG: all fields', allFields);

  var text = '';
  
  var stepStack = savedData['steps-stack'];
  
  // simple cleanup html
  function cleanupHTML(text) { 
    try {
      // Remove any HTML tags from the display text
      var cleanText = text.replace(/<[^>]*>/g, '');
      return cleanText;
    } catch (e) {
      // If anything goes wrong, return the original text
      return text;
    }
  }

  for (var key in savedData) {
    if (savedData.hasOwnProperty(key)) {
      let ref = allFields[key];

      if (!ref) {
        continue;
      }

      // not in step stack
      if (stepStack.indexOf(ref.stepId) === -1) {
        continue;
      }

      let savedValue = savedData[key];

      if (savedValue === null) {
        continue;
      }

      text += ref.title + ':';
      if (ref) {
        if (ref.type === 'radio' && ref.options && ref.options.length) {
          for (let j=0; j< ref.options.length; j++) {
            if (ref.options[j].value === savedValue) {
              text += cleanupHTML(ref.options[j].display);
            }
          }
        } else if (ref.type === 'multiselect' && ref.options && ref.options.length) {
          for (let j=0; j< ref.options.length; j++) {
            if (savedValue.indexOf(ref.options[j].value) > -1) {
              text += cleanupHTML(ref.options[j].display + '; ');
            }
          }
        }
      }
      text += '\n';
    }
  }
  
  // get current URL
  var url = window.location.href;
  text += '\nResult Page:' + url;

  // console.log('DEBUG: text', text);

  var $journeyQuizField = $('.journey-quiz textarea');
  if ($journeyQuizField.length) { 
    $journeyQuizField.val(text);    
  }

  // enquiry type
  // console.log('DEBUG: savedData', savedData);
  let enquiryTypeValue = '';
  if (savedData['q2-supporttype']) {
    enquiryTypeValue = savedData['q2-supporttype'];
  } else if (savedData['q3a-supporttype']) {
    enquiryTypeValue = savedData['q3a-supporttype'];
  } else if (savedData['q2b-serviceneed']) {
    enquiryTypeValue = savedData['q2b-serviceneed'];
  }
  if (enquiryTypeValue) {
    let $enquiryTypeField = $('.journey-enquiry-type select');
    let enquiryTypeOption = '';
    if (enquiryTypeValue === 'aged-care') {
      enquiryTypeOption = 'Aged Care';
    } else if (enquiryTypeValue === 'disability-support') {
      enquiryTypeOption = 'Disability Support';
    } else if (enquiryTypeValue === 'mental-health-support') {
      enquiryTypeOption = 'Mental Health Support';
    } else if (enquiryTypeValue === 'veteran-care') {
      enquiryTypeOption = 'Veteran Care';
    }
    if (enquiryTypeOption && $enquiryTypeField.length) {
      $enquiryTypeField.val(enquiryTypeOption);
    }
  }

}

window.quizScriptLoaded = true;