window.quizData = {
    firstStep: 'intro',
    initialStep: 'intro',
    numberOfSteps: 5, // define max number of step (default)
    steps : {
        'intro' : {
            // prev: function() {
            //     return { step: 'intro' };
            // },
            next: function(fields) {
                return { step: 'q1' };
            }
        },
        'q1': {
            title : 'Who are you looking to find support for?',
            description : '',
            stepNumber: 1,
            stepNumberMax: 5, // since questions can go to multiple different path, max step number is not fixed, its better defined here
            fields: {
                'q1-supportfor' : {
                    title : 'Who are you looking to find support for?',
                    type: 'radio',
                    // style: 'horizontal-buttons',
                    style: 'vertical-buttons',
                    autoIcons: true, // auto icons will automatically assign icon with this pattern /wp-content/themes/avivo/img/journey-icons/fieldid-optionid.svg
                    hideTitle: true,
                    options: [
                        {
                            value: 'myself',
                            display: 'Myself - <small>I need support.</small>'
                            // icon: '/wp-content/themes/avivo/img/icon/icon-myself.svg'
                        },
                        {
                            value: 'family-member-friend',
                            display: 'Family member or friend - <small>Someone I care for needs support.</small>'
                            // icon: '/wp-content/themes/avivo/img/icon/icon-friend-family-member-friend.svg'
                        },
                        {
                            value: 'im-carer',
                            display: 'I’m a carer - <small>I need respite for myself.</small>'
                            // icon: '/wp-content/themes/avivo/img/icon/icon-health-professional.svg'
                        },
                        {
                            value: 'client-patient',
                            display: 'A client/patient - <small>Referring as a health professional or Support Coordinator.</small>'
                            // icon: '/wp-content/themes/avivo/img/icon/icon-health-professional.svg'
                        }
                    ]
                }
            },
            // prev: function() {
            //     return { step: 'intro' };
            // },
            next: function(fields) {
                // do validation and return next step
                // return value 
                // {
                //  step: 'q2',
                //  error: 'This feature is not available yet' (when there's error)
                //  result: 'r1' (also must set step to 'result' to show result page)
                // }
                if (!fields['q1-supportfor'].value) {
                    return { error: 'Please select an option' };
                }

                console.log('DEBUG: fields', fields);
                if (fields['q1-supportfor'].value === 'myself' || fields['q1-supportfor'].value === 'family-member-friend') {
                    return { step: 'q2' };
                } else if (fields['q1-supportfor'].value === 'im-carer') {
                    return { step: 'q2a' };
                } else if (fields['q1-supportfor'].value === 'client-patient') {
                    // return { step: 'q3', error: 'This feature is not available yet' };
                    return { step: 'q2b' };
                }
                // return { step: 'q2' };
            }
        },
        'q2': {
            title : 'Which type of support are you looking for?',
            displayFn: function(value,fields) {
                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                    return 'Which type of support does your family member or friend need?';
                } 
                return value;
            },
            description : '',
            stepNumber: 2,
            stepNumberMax: 5,
            fields: {
                'q2-supporttype' : {
                    title : 'Which type of support are you looking for?',
                    displayFn: function(value,fields) {
                        if (fields['q1-supportfor'].value === 'family-member-friend') { 
                            return 'Which type of support does your family member or friend need?';
                        } 
                        return value;
                    },        
                    type: 'radio',
                    // type: 'multiselect',
                    style: 'vertical-buttons',
                    autoIcons: true,
                    hideTitle: true,
                    options: [
                        {
                            value: 'aged-care',
                            display: 'Aged Care'
                            // icon: '/wp-content/themes/avivo/img/icon/icon.svg'
                        },
                        {
                            value: 'disability-support',
                            display: 'Disability Support'
                            // icon: '/wp-content/themes/avivo/img/icon/icon.svg'
                        },
                        {
                            value: 'mental-health-support',
                            display: 'Mental Health Support'
                            // icon: '/wp-content/themes/avivo/img/icon/icon.svg'
                            // displayFn: function(value,fields) { 
                            //     if (fields['q1-supportfor'].value === 'family-member-friend') { 
                            //         return 'My friend/family has been assessed and wants to know what’s next'; 
                            //     } 
                            //     return value;
                            // }
                        },
                        {
                            value: 'veteran-care',
                            display: 'Veteran Care'
                            // icon: '/wp-content/themes/avivo/img/icon/icon.svg'
                        }
                    ]
                }
            },
            // prev: function() {
            //     return { step: 'q1' };
            // },
            next: function(fields) {
                // if (!fields['q2-supporttype'].value || !Array.isArray(fields['q2-supporttype'].value) || fields['q2-supporttype'].value.length === 0) {
                //     return { error: 'Please select an option' };
                // }

                // if (fields['q2-supporttype'].value === 'learn-about-support') {
                //     return { step: 'result', result: 'r1' };
                // } else if (fields['q2-supporttype'].value === 'support-accommodation') {
                //     return { step: 'q3' };
                // } else if (fields['q2-supporttype'].value === 'assessed') {
                //     return { step: 'q5' };
                // }

                // // cleanup q3-serviceneed answers
                // if (fields['q3-serviceneed'] && Array.isArray(fields['q3-serviceneed'].value)) {
                //     fields['q3-serviceneed'].value = [];
                // }
                // if (
                //     !Array.isArray(fields['q2-supporttype'].value) ||
                //     fields['q2-supporttype'].value.length === 0
                // ) {
                //     return { error: 'Please select an option' };
                // }
                if (!fields['q2-supporttype'].value) {
                    return { error: 'Please select an option' };
                }

                return { step: 'q3' };
            },
        },
        'q3': {
            title: 'What services do you need support for?',
            displayFn: function(value,fields) {
                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                    return 'What services does your family member or friend need support for?';
                } 
                return value;
            },
            description: 'Choose as many as you need',
            descriptionFn: function(value,fields) {
                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                    return 'Choose as many as they need';
                } 
                return value;
            },        
            stepNumber: 3,
            stepNumberMax: 5,
            customClass: 'quiz-step--wide',
            fields: {
                'q3-serviceneed' : {
                    title : 'What services do you need support for?',
                    displayFn: function(value,fields) {
                        if (fields['q1-supportfor'].value === 'family-member-friend') { 
                            return 'What services does your family member or friend need support for?';
                        } 
                        return value;
                    },        
                    type: 'multiselect',
                    style: 'vertical-buttons',
                    customClass: 'quiz-field--two-columns',
                    hideTitle: true,
                    autoIcons: true, // auto icons will automatically assign icon with this pattern /wp-content/themes/avivo/img/journey-icons/fieldid-optionid.svg
                    resetOnEnter: true, // tested for multiselect
                    options: [
                        {
                            value: 'in-home-support',
                            display: 'In Home Support'
                        },
                        {
                            value: 'personal-care',
                            display: 'Personal Care'                            
                            // displayFn: function(value,fields) { 
                            //     // this is examples how to hide the value, we use this function but return false, it will set hidden to the option, dont forget to set resetOnEnter on the question
                            //     if (fields['q1-supportfor'].value === 'family-member-friend') { 
                            //         // return 'Personal Care (family member)'; 
                            //       return false;
                            //     } 
                            //     return value;
                            // }
                        },
                        {
                            value: 'social-community-support',
                            display: 'Social &amp; Community Support'
                        },
                        {
                            value: 'transport-services',
                            display: 'Transport Services'
                        },
                        {
                            value: 'home-modifications',
                            display: 'Home Modifications'
                        },
                        {
                            value: 'night-services',
                            display: 'Night Services'
                        },
                        {
                            value: '24-hour-care-at-home',
                            display: '24 Hour Care at Home'
                        },
                        {
                            value: 'post-hospital-care',
                            display: 'Post Hospital Care'
                        },
                        {
                            value: 'nursing',
                            display: 'Nursing'
                        },
                        {
                            value: 'dementia-care',
                            display: 'Dementia Care'
                        },
                        {
                            value: 'palliative-care',
                            display: 'Palliative Care'
                        },
                        {
                            value: 'shared-living',
                            display: 'Shared Living'
                        },
                        {
                            value: 'respite-for-carers',
                            display: 'Respite for Carers'
                        },
                        {
                            value: 'family-carer-support',
                            display: 'Family &amp; Carer Support'
                        },
                        {
                            value: 'allied-health-care-coordination',
                            display: 'Allied Health Care Coordination'
                        },
                        {
                            value: 'icls',
                            display: 'Individualised Community Living Strategy (ICLS)'
                        },
                        {
                            value: 'mental-health',
                            display: 'Mental Health'
                        }
                    ]
                }
            },
            next: function(fields) {
              if (
                  !Array.isArray(fields['q3-serviceneed'].value) ||
                  fields['q3-serviceneed'].value.length === 0
              ) {
                  return { error: 'Please select an option' };
              }

                // if (fields['q3-serviceneed'].value === 'move-into-retirement-village') {
                //     return { step: 'q6' };
                // }

                return { step: 'q4' };
            },
            enter: function(fields) {
              //   alert('on enter!!');
              // console.log('DEBUG: on enter', fields);
                // TODO: can't just do below, need to update the UI as well
                // // cleanup q3-serviceneed answers
                // if (fields['q3-serviceneed'] && Array.isArray(fields['q3-serviceneed'].value)) {
                //     fields['q3-serviceneed'].value = [];
                // }

            }
        },
        'q4': {
            title: 'Do you already have funding arranged?',
            displayFn: function(value,fields) { 
                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                    return 'Does your family member or friend already have funding arranged for aged care services?'; 
                } 
                return value;
            },
            description: '',
            stepNumber: 4,
            stepNumberMax: 5,
            fields: {
                'q4-funding' : {
                    title : 'Do you already have funding arranged?',
                    displayFn: function(value,fields) { 
                        if (fields['q1-supportfor'].value === 'family-member-friend') { 
                            return 'Does your family member or friend already have funding arranged for aged care services?'; 
                        } 
                        return value;
                    },
                    type: 'radio',
                    style: 'vertical-buttons',
                    hideTitle: true,
                    options: [
                        {
                            value: 'yes-funding-approved',
                            display: 'Yes <small>— I have had my funding approved</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'Yes <small>— They have had my funding approved</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'yes-self-funding',
                            display: 'Yes <small>— I am self-funding my care</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'Yes — <small>They are self-funding their care.</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'no-need-guidance',
                            display: 'No <small>-I haven’t arranged funding yet; I need guidance on my options.</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'No <small>-They haven’t arranged funding yet; they need guidance on their options.</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'no-waiting-approval',
                            display: 'No <small>— I am waiting for funding approval</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'No <small>— They are waiting for funding approval</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'unsure-need-help',
                            display: 'Unsure <small>— I need help with my next steps</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'Unsure <small>— They need help with their next steps</small>'; 
                                } 
                                return value;
                            }
                        }
                    ]
                }
            },
            next: function(fields) {
                if (!fields['q4-funding'].value) {
                    return { error: 'Please select an option' };
                }

                if (fields['q4-funding'].value === 'yes-funding-approved') {
                    return { step: 'q5' };
                } 
                return { step: 'result', result: 'r1' };
            }
        },
        'q5': {
            title: 'Which type of government-subsidised funding do you have?',
            displayFn: function(value,fields) { 
                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                    return 'Which type of government-subsidised funding does your family member or friend have?'; 
                } 
                return value;
            },
            description: '',
            stepNumber: 5,
            stepNumberMax: 6,
            fields: {
                'q5-government-funds' : {
                    title : 'Which type of government-subsidised funding do you have?',
                    displayFn: function(value,fields) { 
                        if (fields['q1-supportfor'].value === 'family-member-friend') { 
                            return 'Which type of government-subsidised funding does your family member or friend have?'; 
                        } 
                        return value;
                    },
                    type: 'radio',
                    style: 'vertical-buttons',
                    hideTitle: true,
                    options: [
                        {
                            value: 'home-care-package',
                            display: 'Home Care Package (Support at Home starting Nov 1)'
                        },
                        {
                            value: 'commonwealth-home-support-programme',
                            display: 'Commonwealth Home Support Programs (CHSP)'
                        },
                        {
                            value: 'ndis',
                            display: 'NDIS'
                        },
                        {
                            value: 'mental-health-commission',
                            display: 'Mental Health Commission'
                        },
                        {
                            value: 'veterans-home-care-program',
                            display: 'Veterans Home Care Program'
                        },
                        {
                            value: 'other',
                            display: 'Other'
                        }
                    ]
                }
            
            },
            next: function(fields) {
            //   if (
            //       !Array.isArray(fields['q5-government-funds'].value) ||
            //       fields['q5-government-funds'].value.length === 0
            //   ) {
            //       return { error: 'Please select an option' };
            //   }
                if (!fields['q5-government-funds'].value) {
                    return { error: 'Please select an option' };
                }
              
                return { step: 'result', result: 'r1' };
            }
        },
        'q2a': {
            title: 'How can Avivo support you in your caring role?',
            description: 'Select all that apply',
            stepNumber: 2,
            stepNumberMax: 4,
            fields: {
                'q2a-caring-role-support': {
                    title : 'How can Avivo support you in your caring role?',
                    type: 'multiselect',
                    style: 'vertical-buttons',
                    hideTitle: true,
                    options: [
                        {
                            value: 'respite-for-carers',
                            display: 'Respite for Carers'
                        },
                        {
                            value: 'family-carer-support',
                            display: 'Family &amp; Carer Support'
                        },
                        {
                            value: 'funding-options-advice',
                            display: 'Funding Options and Advice'
                        },
                        {
                            value: 'carer-events',
                            display: 'Carer Events'
                        },
                        {
                            value: 'personal-development-opportunities',
                            display: 'Personal Development Opportunities'
                        }
                    ]
                }            
            },
            next: function(fields) {
              if (
                  !Array.isArray(fields['q2a-caring-role-support'].value) ||
                  fields['q2a-caring-role-support'].value.length === 0
              ) {
                  return { error: 'Please select an option' };
              }
              return { step: 'q3a' };
            }
        },
        'q3a': {
            title: 'Which type of support does the person you care for need?',
            description: '',
            stepNumber: 3,
            stepNumberMax: 4,
            fields: {
                'q3a-supporttype': {
                    title : 'Which type of support does the person you care for need?',
                    type: 'radio',
                    style: 'vertical-buttons',
                    autoIcons: true,
                    hideTitle: true,
                    options: [
                        {
                            value: 'aged-care',
                            display: 'Aged Care'
                        },
                        {
                            value: 'disability-support',
                            display: 'Disability Support'
                        },
                        {
                            value: 'mental-health-support',
                            display: 'Mental Health Support'
                        },
                        {
                            value: 'veteran-care',
                            display: 'Veteran Care'
                        }
                    ]
                }            
            },
            next: function(fields) {
            //   if (
            //       !Array.isArray(fields['q3a-supporttype'].value) ||
            //       fields['q3a-supporttype'].value.length === 0
            //   ) {
            //       return { error: 'Please select an option' };
            //   }
                if (!fields['q3a-supporttype'].value) {
                    return { error: 'Please select an option' };
                }
              
              return { step: 'result', result: 'r2' };
            }
        },

        'q2b': {
            title: 'What kind of care does you client / patient need?',
            description: 'Select all that apply',
            stepNumber: 2,
            stepNumberMax: 4,
            fields: {
                'q2b-serviceneed': {
                    title : 'What kind of care does you client / patient need?',
                    type: 'multiselect',
                    style: 'vertical-buttons',
                    hideTitle: true,
                    autoIcons: true,
                    options: [
                        {
                            value: 'aged-care',
                            display: 'Aged Care'
                        },
                        {
                            value: 'disability-support',
                            display: 'Disability Support'
                        },
                        {
                            value: 'mental-health-support',
                            display: 'Mental Health Support'
                        },
                        {
                            value: 'veteran-care',
                            display: 'Veteran Care'
                        }
                    ]
                }            
            },
            next: function(fields) {
              // if (
              //     !Array.isArray(fields['q2b-serviceneed'].value) ||
              //     fields['q2b-serviceneed'].value.length === 0
              // ) {
              //     return { error: 'Please select an option' };
              // }
              if (
                  !Array.isArray(fields['q2b-serviceneed'].value) ||
                  fields['q2b-serviceneed'].value.length === 0
              ) {
                  return { error: 'Please select an option' };
              }
              
                return { step: 'q3b' };
            }
        },
        'q3b': {
            title: 'What services do you need support for?',
            description: '(Select all that apply)',
            stepNumber: 3,
            stepNumberMax: 4,
            customClass: 'quiz-step--wide',
            fields: {
                'q3b-support-type': {
                    title : 'What services do you need support for?',
                    type: 'multiselect',
                    style: 'vertical-buttons',
                    hideTitle: true,
                    customClass: 'quiz-field--two-columns',
                    autoIcons: true,
                    options: [
                        {
                            value: 'in-home-support',
                            display: 'In Home Support'
                        },
                        {
                            value: 'personal-care',
                            display: 'Personal Care'
                        },
                        {
                            value: 'social-community-support',
                            display: 'Social & Community Support'
                        },
                        {
                            value: 'transport-services',
                            display: 'Transport Services'
                        },
                        {
                            value: 'home-modifications',
                            display: 'Home Modifications'
                        },
                        {
                            value: 'night-services',
                            display: 'Night Services'
                        },
                        {
                            value: '24-hour-care-at-home',
                            display: '24 Hour Care at Home'
                        },
                        {
                            value: 'post-hospital-care',
                            display: 'Post Hospital Care'
                        },
                        {
                            value: 'nursing',
                            display: 'Nursing'
                        },
                        {
                            value: 'dementia-care',
                            display: 'Dementia Care'
                        },
                        {
                            value: 'palliative-care',
                            display: 'Palliative Care'
                        },
                        {
                            value: 'shared-living',
                            display: 'Shared Living'
                        },
                        {
                            value: 'respite-for-carers',
                            display: 'Respite for Carers'
                        },
                        {
                            value: 'family-carer-support',
                            display: 'Family & Carer Support'
                        },
                        {
                            value: 'allied-health-care-coordination',
                            display: 'Allied Health Care Coordination'
                        },
                        {
                            value: 'individualised-community-living-strategy',
                            display: 'Individualised Community Living Strategy (ICLS)'
                        },
                        {
                            value: 'mental-health',
                            display: 'Mental Health'
                        }
                    ]
                }            
            },
            next: function(fields) {
              if (
                  !Array.isArray(fields['q3b-support-type'].value) ||
                  fields['q3b-support-type'].value.length === 0
              ) {
                  return { error: 'Please select an option' };
              }
              
                return { step: 'result', result: 'r3' };
            }
        }

        
    },
    results: {
        'r1': {
            // 'redirect' : '/r1-how-to-access-support/',
            'redirectFn' : function(fields) {
                // return '/r1-how-to-access-support/?supportfor=' + fields['q1-supportfor'].value;
                return '/your-journey/ndis-approved/';
            }
        },
        'r2': {
            'redirect' : '/carers-support/'
        },
        'r3': {
            'redirect' : '/refer-to-us/'
        }
    }
};

// console.log('DEBUG: quizData', window.quizData);
