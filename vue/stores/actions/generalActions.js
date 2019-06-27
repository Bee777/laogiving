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
                            if(res.data.success){
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
            c.commit('setValidated', {errors: {loading_search_posts: true}});
            client.get(`${apiUrl}/home/posts/${i.type}?${request}`, ajaxConfig.getHeaders())
                .then(res => {
                    c.commit('setSearchQuery', {text: i.q, filters: i.filters});
                    c.commit('setClearMsg', {delay: 300});
                    c.commit('setPostsData', {data: res.data, type: i.type})
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
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
    }
};
