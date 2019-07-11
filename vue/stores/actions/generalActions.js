import {createAxiosClient} from "@vue/initial/api/axios-client";

let {client, ajaxConfig, apiUrl} = createAxiosClient();
const ajaxToken = (c, formData = false) => {
    if (formData) {
        ajaxConfig.addHeader('Content-Type', 'multipart/form-data');
    } else {
        ajaxConfig.addHeader('Content-Type', 'application/json');
    }
    return ajaxConfig.addHeader('CL-Token', c.getters.getToken);
};
export const axiosClient = () => createAxiosClient();
export const createActions = (utils) => {
    return {
        register(c, user) {
            return new Promise((r, n) => {
                utils.Validate(user, {
                    'name': ['required'],
                    'email': ['email', 'required'],
                    'password': ['required', 'confirm', {min: 8}],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading: 'yes'}});
                    client.post(`${apiUrl}/guest/register-user`, user, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg', {delay: 1000});
                            utils.setSession('registered', true);
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });

            })
        },
        forgotPassword(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'email': ['email', 'required', {max: 191}],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading: 'yes'}});
                    client.post(`${apiUrl}/guest/forgot-password`, data, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                            if (res.data.success) {
                                c.commit('setSucceed', {succeed: {msg: res.data.status}})
                            }
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /*** @HomeData **/
        fetchHomeData(c, i) {
            client.get(`${apiUrl}/home/index`, ajaxConfig.getHeaders())
                .then(res => {
                    c.commit('setClearMsg');
                    c.commit('setHomeData', res.data.data)
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @HomeData **/
        /*** @ResetPasswordActionsAndData **/
        initResetForm(c, token) {
            return new Promise((r, n) => {
                c.commit('setValidated', {errors: {loading_reset: true}});
                client.post(`${apiUrl}/guest/forgot-password/email/${token}`, {}, ajaxConfig)
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    });
            })
        },
        resetPassword(c, user) {
            return new Promise((r, n) => {
                utils.Validate(user, {
                    'email': ['email', 'required'],
                    'password': ['required', 'confirm', {min: 6}],
                    'password_confirmation': ['required', {min: 6}],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading_reset: true}});
                    client.post(`${apiUrl}/guest/password/reset`, user, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg', {delay: 1000});
                            utils.setSession('finished-reset-password', true);
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            })
        },
        /*** @ResetPasswordActionsAndData **/
        /*** @PostsData **/
        fetchPostsData(c, i) {
            let request = `limit=${i.limit}&page=${i.page}&q=${i.q}`;

            let options_request = '';
            for (let o in i.options) {
                if (i.options.hasOwnProperty(o)) {
                    let op = i.options[o] || '';
                    op = utils.isArray(op) ? op.join(',') : op;
                    options_request += `&${o}=${op}`;
                }
            }

            c.commit('setValidated', {errors: {loading_search_posts: true}});
            client.get(`${apiUrl}/home/posts/${i.type}?${request}${options_request}`, ajaxConfig.getHeaders())
                .then(res => {
                    c.commit('setSearchQuery', {text: i.q, filters: i.filters});
                    c.commit('setClearMsg', {delay: 300});
                    c.commit('setPostsData', {data: res.data, type: i.type})
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        postReportAbuse(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'email': ['required', 'email', {max: 191}],
                    'reason': ['required', {max: 800}],
                }).then(v => {
                    client.post(`${apiUrl}/home/send-report-abuse`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err);
                        });

                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postSaveBookMark(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'post_id': ['required', {max: 191}],
                    'checked': ['required', {max: 191}],
                    'type': ['required', {max: 191}]
                }).then(v => {
                    client.post(`${apiUrl}/users/save-post-bookmark`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err);
                        });

                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /*** @PostsData **/
        /*** @PostsData **/
        fetchSinglePostsData(c, i) {
            c.commit('setValidated', {errors: {loading_single_posts: true}});
            client.get(`${apiUrl}/home/posts/${i.type}/single/${i.id}`, ajaxConfig.getHeaders())
                .then(res => {
                    if (res.data.success !== false) {
                        c.commit('setClearMsg', {delay: 300});
                        c.commit('setSinglePostsData', {data: res.data, type: i.type})
                    } else {
                        utils.Location('/');
                    }
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @PostsData **/
        /***@SendContactInfo */
        postSendContact(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'email': ['email', 'required'],
                    'name': ['required', {max: 191}],
                    'message': ['required'],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading_send_contact: true}});
                    client.post(`${apiUrl}/home/contact-info`, data, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            })
        },
        /***@SendContactInfo */

        /***@SaveNewsLetter */
        postSaveNewsLetter(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'email': ['email', 'required'],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading_send_contact: true}});
                    client.post(`${apiUrl}/home/save-receive-news-letter`, data, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            })
        },
        /***@SaveNewsLetter */
        /***@SignUpVolunteering */
        postSignUpVolunteering(c, data) {
            return new Promise((r, n) => {
                let rule = {};
                // validate volunteer_contact_phone_number
                if (data.activity.volunteer_contact_phone_number === 'yes') {
                    rule.volunteer_contact_phone_number = ['required', 'phone number'];
                }
                // validate other_response_required
                if (!utils.isEmptyVar(data.activity.other_response_required)) {
                    rule.other_response_answer = ['required', {max: 500}];
                }
                // validate your_minimum_age
                if (data.need_date_of_birth) {
                    let minimum_age = 13;
                    let position = data.activity.positions.filter(f => {
                        return f.id === data.model.volunteer_position;
                    }).shift() || {};
                    if (!utils.isEmptyObject(position)) {
                        minimum_age = position.minimum_age;
                    }
                    data.model.current_date = new Date().toLocaleDateString();
                    rule.your_date_of_birth = ['required', {
                        lessThan: 'current_date',
                        type: 'date'
                    }];
                    data.model.your_minimum_age = (data.model.your_date_of_birth ? utils.calculateAge(new Date(data.model.your_date_of_birth)) : 0);
                    rule.your_minimum_age = [{min: minimum_age, type: 'number'}];
                }
                //validate all data form
                utils.Validate(data.model, {
                    'volunteer_position': ['required'],
                    ...rule
                }).then((v) => {
                    data.model.activity_id = data.activity.id;
                    c.commit('setValidated', {errors: {loading_signup_volunteering: true}});
                    client.post(`${apiUrl}/users/save-signup-volunteering`, data.model, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            if (err.response && err.response.data && err.response.data.errors) {
                                let resErr = err.response.data.errors;
                                if (resErr['sign_up_not_valid']) {
                                    resErr = utils.fetchErrors(resErr);
                                    c.dispatch('showErrorToast', {msg: resErr['sign_up_not_valid'], dt: 3500});
                                }
                            }
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    c.dispatch('showErrorToast', {msg: 'Please check your form again!', dt: 3500});
                    n(e);
                });
            });
        },
        /***@SignUpVolunteering */
        /***@fetchSignUpVolunteeringSuccess */
        fetchVolunteeringSignUpSuccess(c, data) {
            return new Promise((r, n) => {
                c.commit('setValidated', {errors: {loading_fetch_volunteering_sign_up_success: true}});
                client.get(`${apiUrl}/users/fetch-signup-volunteering-success/${data}`, ajaxConfig)
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    });
            })
        },
        /***@fetchSignUpVolunteeringSuccess */
    }
};
