window.quizData = {
    firstStep: 'intro',
    initialStep: 'intro',
    numberOfSteps: 5, // define max number of step (default)
    steps : {
        'intro' : {
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
                            display: 'Myself <small> - I need support.</small>'
                        },
                        {
                            value: 'family-member-friend',
                            display: 'Family member or friend <small> - Someone I care for needs support.</small>'
                        },
                        {
                            value: 'im-carer',
                            display: 'I’m a carer <small> - I need respite for myself.</small>'
                            // icon: '/wp-content/themes/avivo/img/icon/icon-health-professional.svg'
                        },
                        {
                            value: 'client-patient',
                            display: 'A client/patient <small> - Referring as a health professional or Support Coordinator.</small>'
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
                            display: 'Aged care'
                        },
                        {
                            value: 'disability-support',
                            display: 'Disability support'
                        },
                        {
                            value: 'mental-health-support',
                            display: 'Mental health support'
                            // displayFn: function(value,fields) { 
                            //     if (fields['q1-supportfor'].value === 'family-member-friend') { 
                            //         return 'My friend/family has been assessed and wants to know what’s next'; 
                            //     } 
                            //     return value;
                            // }
                        },
                        {
                            value: 'veteran-care',
                            display: 'Veteran care'
                        }
                    ]
                }
            },
            next: function(fields) {
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
                            display: 'In home support'
                        },
                        {
                            value: 'personal-care',
                            display: 'Personal care',
                            displayFn: function(value,fields) { 
                                // this is examples how to hide the value, we use this function but return false, it will set hidden to the option, dont forget to set resetOnEnter on the question
                                if (['aged-care', 'disability-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'social-community-support',
                            display: 'Social &amp; community support'
                        },
                        {
                            value: 'transport-services',
                            display: 'Transport services',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'disability-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'home-modifications',
                            display: 'Home modifications',
                            displayFn: function(value,fields) { 
                                if (['aged-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'night-services',
                            display: 'Night services',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'disability-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: '24-hour-care-at-home',
                            display: '24-hour care at home',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'disability-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'post-hospital-care',
                            display: 'Post-hospital care',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'veteran-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'nursing',
                            display: 'Nursing',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'disability-support','veteran-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'dementia-care',
                            display: 'Dementia care',
                            displayFn: function(value,fields) { 
                                if (['aged-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'end-of-life-care',
                            display: 'End-of-life care',
                            displayFn: function(value,fields) { 
                                if (['aged-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        // {
                        //     value: 'shared-living',
                        //     display: 'Shared living',
                        //     displayFn: function(value,fields) { 
                        //         if (['veteran-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                        //             return false;
                        //         }
                        //         return value;
                        //     }
                        // },
                        {
                            value: 'respite-for-carers',
                            display: 'Respite for carers',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'mental-health-support','veteran-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'family-carer-support',
                            display: 'Family &amp; carer support',
                            displayFn: function(value,fields) { 
                                if (['disability-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'allied-health-care-coordination',
                            display: 'Allied health care coordination',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'disability-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'icls',
                            display: 'Individualised community living strategy (ICLS)',
                            displayFn: function(value,fields) { 
                                if (['mental-health-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'mental-health',
                            display: 'Mental health',
                            displayFn: function(value,fields) { 
                                if (['aged-care', 'disability-support','veteran-care'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'service-navigation-guidance',
                            display: 'Service navigation guidance',
                            displayFn: function(value,fields) { 
                                if (['mental-health-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'other',
                            display: 'Other',
                            displayFn: function(value,fields) { 
                                if (['mental-health-support'].indexOf(fields['q2-supporttype'].value) === -1) { 
                                    return false;
                                }
                                return value;
                            }
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
                if (fields['q2-supporttype'].value === 'aged-care') {
                    if (fields['q1-supportfor'].value === 'family-member-friend') { 
                        return 'Does your family member or friend already have funding arranged for aged care services?'; 
                    } else {
                        return 'Do you already have funding arranged for aged care services?';
                    }
                } else if (fields['q2-supporttype'].value === 'disability-support') {
                    if (fields['q1-supportfor'].value === 'family-member-friend') { 
                        return 'Does your family member or friend already have funding arranged for disability support?'; 
                    } else {
                        return 'Do you already have funding arranged for disability support?';
                    }
                } else {
                    if (fields['q1-supportfor'].value === 'family-member-friend') { 
                        return 'Do your family member or friend already have funding arranged?'; 
                    } 
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
                            display: 'Yes <small>- I have had my funding approved</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'Yes <small>- They have had funding approved</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'yes-self-funding',
                            display: 'Yes <small>- I am self-funding my care</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'Yes - <small>They are self-funding their care.</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'no-waiting-approval',
                            display: 'No <small>- I am waiting for funding approval</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'No <small>- They are waiting for funding approval</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'no-need-guidance',
                            display: 'No <small>- I haven’t arranged funding yet; I need guidance on my options.</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'No <small>- They haven’t arranged funding yet; they need guidance on their options.</small>'; 
                                } 
                                return value;
                            }
                        },
                        {
                            value: 'unsure-need-help',
                            display: 'Unsure <small>- I need help with my next steps</small>',
                            displayFn: function(value,fields) { 
                                if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                    return 'Unsure <small>- They need help with their next steps</small>'; 
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

                if ((fields['q4-funding'].value === 'yes-funding-approved') || (fields['q4-funding'].value === 'no-waiting-approval')) {
                    return { step: 'q5' };
                } else if (fields['q4-funding'].value === 'yes-self-funding') {
                    if (fields['q2-supporttype'].value === 'aged-care') {
                        return { step: 'result', result: 'result-self-funding-aged-care' };
                    } else if (fields['q2-supporttype'].value === 'disability-support') {
                        return { step: 'result', result: 'result-self-funding-disability-support' };
                    } else if (fields['q2-supporttype'].value === 'mental-health-support') {
                        return { step: 'result', result: 'result-self-funding-mental-health-support' };
                    } else if (fields['q2-supporttype'].value === 'veteran-care') {
                        return { step: 'result', result: 'result-self-funding-veteran-care' };
                    }
                } else {
                    // havent arranged funding or need help
                    // beginning, depend on q2-supporttype
                    if (fields['q2-supporttype'].value === 'aged-care') {
                        return { step: 'result', result: 'result-sah-beginning' };
                    } else if (fields['q2-supporttype'].value === 'disability-support') {
                        return { step: 'result', result: 'result-ndis-beginning' };
                    } else if (fields['q2-supporttype'].value === 'mental-health-support') {
                        return { step: 'result', result: 'result-mental-health-support-beginning' };
                    } else if (fields['q2-supporttype'].value === 'veteran-care') {
                        return { step: 'result', result: 'result-vhc-beginning' };
                    }

                    // return { step: 'result', result: 'r1' };

                }
            }
        },
        'q5': {
            title: 'Which type of government-subsidised funding do you have?',
            displayFn: function(value,fields) { 
                if (fields['q4-funding'].value === 'no-waiting-approval') {
                    if (fields['q1-supportfor'].value === 'family-member-friend') { 
                        return 'Which type of government-subsidised funding is your family member or friend waiting for approval for?'; 
                    } else {
                        return 'Which type of government-subsidised funding are you waiting for approval for?';
                    }
                } else {
                    if (fields['q1-supportfor'].value === 'family-member-friend') { 
                        return 'Which type of government-subsidised funding does your family member or friend have?'; 
                    } 
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
                        if (fields['q4-funding'].value === 'no-waiting-approval') {
                            if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                return 'Which type of government-subsidised funding is your family member or friend waiting for approval for?'; 
                            } else {
                                return 'Which type of government-subsidised funding are you waiting for approval for?';
                            }
                        } else {
                            if (fields['q1-supportfor'].value === 'family-member-friend') { 
                                return 'Which type of government-subsidised funding does your family member or friend have?'; 
                            } 
                        }
                        return value;
                    },
                    type: 'radio',
                    style: 'vertical-buttons',
                    hideTitle: true,
                    options: [
                        {
                            value: 'support-at-home',
                            display: 'Support at Home',
                            displayFn: function(value,fields) { 
                                // only show for aged-care
                                if (fields['q2-supporttype'].value !== 'aged-care') { 
                                  return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'commonwealth-home-support-program',
                            display: 'Commonwealth Home Support Program (CHSP)',
                            displayFn: function(value,fields) { 
                                // only show for aged-care
                                if (fields['q2-supporttype'].value !== 'aged-care') { 
                                  return false;
                                }
                                return value;
                            }
                        },
                        {
                            value: 'ndis',
                            display: 'NDIS',
                            displayFn: function(value,fields) { 
                                // only show for disability-support
                                if (fields['q2-supporttype'].value !== 'disability-support') { 
                                  return false;
                                } 
                                return value;
                            }

                        },
                        {
                            value: 'mental-health-commission',
                            display: 'Mental Health Commission',
                            displayFn: function(value,fields) { 
                                // only show for mental-health-support
                                if (fields['q2-supporttype'].value !== 'mental-health-support') { 
                                  return false;
                                }
                                return value;
                            }

                        },
                        {
                            value: 'veterans-home-care-program',
                            display: 'Veterans Home Care program',
                            displayFn: function(value,fields) { 
                                // only show for aged-care and veterans
                                if (fields['q2-supporttype'].value !== 'aged-care' && fields['q2-supporttype'].value !== 'veteran-care') { 
                                  return false;
                                }
                                return value;
                            }
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
              

                if (fields['q5-government-funds'].value === 'support-at-home') {
                    if (fields['q4-funding'].value === 'yes-funding-approved') {
                        return { step: 'result', result: 'result-sah-approved' };
                    } else if (fields['q4-funding'].value === 'no-waiting-approval') {
                        return { step: 'result', result: 'result-sah-waiting' };
                    }
                } else if (fields['q5-government-funds'].value === 'commonwealth-home-support-program') {
                    if (fields['q4-funding'].value === 'yes-funding-approved') {
                        return { step: 'result', result: 'result-chsp-approved' };
                    } else if (fields['q4-funding'].value === 'no-waiting-approval') {
                        return { step: 'result', result: 'result-chsp-waiting' };
                    }
                } else if (fields['q5-government-funds'].value === 'ndis') {
                    if (fields['q4-funding'].value === 'yes-funding-approved') {
                        return { step: 'result', result: 'result-ndis-approved' };
                    } else if (fields['q4-funding'].value === 'no-waiting-approval') {
                        return { step: 'result', result: 'result-ndis-waiting' };
                    }
                } else if (fields['q5-government-funds'].value === 'mental-health-commission') {
                    if (fields['q4-funding'].value === 'yes-funding-approved') {
                        return { step: 'result', result: 'result-mental-health-support-approved' };
                    } else if (fields['q4-funding'].value === 'no-waiting-approval') {
                        return { step: 'result', result: 'result-mental-health-support-waiting' };
                    }
                } else if (fields['q5-government-funds'].value === 'veterans-home-care-program') {
                    if (fields['q4-funding'].value === 'yes-funding-approved') {
                        return { step: 'result', result: 'result-vhc-approved' };
                    } else if (fields['q4-funding'].value === 'no-waiting-approval') {
                        return { step: 'result', result: 'result-vhc-waiting' };
                    }
                }

                // default: other??
                return { step: 'result', result: 'result-default' };
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
                        // {
                        //     value: 'family-carer-support',
                        //     display: 'Family &amp; Carer Support'
                        // },
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

              return { step: 'result', result: 'result-carer-support-beginning' };
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
            title: 'What services does you client / patient need support for?',
            description: '(Select all that apply)',
            stepNumber: 3,
            stepNumberMax: 4,
            customClass: 'quiz-step--wide',
            fields: {
                'q3b-support-type': {
                    title : 'What services does you client / patient need support for?',
                    type: 'multiselect',
                    style: 'vertical-buttons',
                    hideTitle: true,
                    customClass: 'quiz-field--two-columns',
                    autoIcons: true,
                    options: [
                        {
                            value: 'in-home-support',
                            display: 'In home support'
                        },
                        {
                            value: 'personal-care',
                            display: 'Personal care'
                        },
                        {
                            value: 'social-community-support',
                            display: 'Social & community support'
                        },
                        {
                            value: 'transport-services',
                            display: 'Transport services'
                        },
                        {
                            value: 'home-modifications',
                            display: 'Home modifications'
                        },
                        {
                            value: 'night-services',
                            display: 'Night services'
                        },
                        {
                            value: '24-hour-care-at-home',
                            display: '24-hour care at home'
                        },
                        {
                            value: 'post-hospital-care',
                            display: 'Post-hospital care'
                        },
                        {
                            value: 'nursing',
                            display: 'Nursing'
                        },
                        {
                            value: 'dementia-care',
                            display: 'Dementia care'
                        },
                        {
                            value: 'end-of-life-care',//'palliative-care',
                            display: 'End-of-life care'//'Palliative Care'
                        },
                        {
                            value: 'shared-living',
                            display: 'Shared living'
                        },
                        {
                            value: 'respite-for-carers',
                            display: 'Respite for carers'
                        },
                        {
                            value: 'family-carer-support',
                            display: 'Family & carer support'
                        },
                        {
                            value: 'allied-health-care-coordination',
                            display: 'Allied health care coordination'
                        },
                        {
                            value: 'individualised-community-living-strategy',
                            display: 'Individualised Community Living Strategy (ICLS)'
                        },
                        {
                            value: 'mental-health',
                            display: 'Mental health'
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
              
                return { step: 'result', result: 'result-referral' };
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
        },
        'result-ndis-approved': { 'redirect' : '/your-journey/ndis-approved/' },
        'result-ndis-waiting': { 'redirect' : '/your-journey/ndis-waiting/' },
        'result-ndis-beginning': { 'redirect' : '/your-journey/ndis-beginning/' },
        'result-sah-approved': { 'redirect' : '/your-journey/sah-approved/' },
        'result-sah-waiting': { 'redirect' : '/your-journey/sah-waiting/' },
        'result-sah-beginning': { 'redirect' : '/your-journey/sah-beginning/' },
        'result-chsp-approved': { 'redirect' : '/your-journey/chsp-approved/' },
        'result-chsp-waiting': { 'redirect' : '/your-journey/chsp-waiting/' },
        'result-chsp-beginning': { 'redirect' : '/your-journey/chsp-beginning/' },
        'result-vhc-approved': { 'redirect' : '/your-journey/vhc-approved/' },
        'result-vhc-waiting': { 'redirect' : '/your-journey/vhc-waiting/' },
        'result-vhc-beginning': { 'redirect' : '/your-journey/vhc-beginning/' },
        'result-mental-health-support-approved': { 'redirect' : '/your-journey/mental-health-support-approved/' },
        'result-mental-health-support-waiting': { 'redirect' : '/your-journey/mental-health-support-waiting/' },
        'result-mental-health-support-beginning': { 'redirect' : '/your-journey/mental-health-support-beginning/' },
        'result-carer-support-approved': { 'redirect' : '/your-journey/carer-support-approved/' },
        'result-carer-support-waiting': { 'redirect' : '/your-journey/carer-support-waiting/' },
        'result-carer-support-beginning': { 'redirect' : '/your-journey/carer-support-beginning/' },

        'result-self-funding-aged-care': { 'redirect' : '/your-journey/self-funding-aged-care/' },
        'result-self-funding-disability-support': { 'redirect' : '/your-journey/self-funding-disability-support/' },
        'result-self-funding-mental-health-support': { 'redirect' : '/your-journey/self-funding-mental-health-support/' },
        'result-self-funding-veteran-care': { 'redirect' : '/your-journey/self-funding-veteran-care/' },

        'result-referral': { 'redirect' : '/your-journey/referral/' },

        'result-default': { 'redirect' : '/your-journey/result/' }

    }
};

// console.log('DEBUG: quizData', window.quizData);
