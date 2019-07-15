import {createAxiosClient} from "../../initial/api/axios-client";

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
        fetchSearches(c, i) {

            let filters = '';
            for (let filter in i.filters) {
                if (i.filters.hasOwnProperty(filter)) {
                    filters += `&${filter}=${i.filters[filter] || ''}`;
                }
            }
            let request = `limit=${i.limit}&page=${i.page}&q=${i.q}${filters}`;
            c.commit('setValidated', {errors: {loading_searches: true}});
            client.get(`${apiUrl}/users/searches/${i.type}?${request}`, ajaxToken(c))
                .then(res => {
                    c.commit('setSearchesData', {type: i.type, data: res.data.data, options: res.data.options});
                    c.commit('setClearMsg');
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /***  @UsersSettings Profile **/
        /*** @UserProfile **/
        fetchOptionProfileData(c, data) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/profile-options?type=volunteer`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        postManageUserProfile(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'profile_image': [{mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                    'display_name': ['required', {max: 191}],
                    'public_email': ['email', {max: 191}],
                    'phone_number': ['phone number', {max: 191}],
                }).then(v => {
                    let info = utils.clone(data);
                    for (let i in info) {
                        if (info.hasOwnProperty(i)) {
                            if (utils.isEmptyVar(info[i])) {
                                info[i] = '';
                            }
                        }
                    }
                    let formData = new FormData();
                    utils.addDataForm(['display_name',
                        'public_email',
                        'date_of_birth',
                        'salutation',
                        'gender',
                        'phone_number',
                        'address',
                        'facebook',
                        'website',
                        'about',
                    ], formData, info);
                    (info.user_causes || []).map((i) => {
                        formData.append('user_causes[]', i);
                    });
                    if (info.profile_image) {//check if user change image
                        formData.append('profile_image', info.profile_image.file);
                    }
                    client.post(`${apiUrl}/users/profile-manage?type=volunteer`, formData, ajaxToken(c, true))
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
        /*** @UserProfile **/
        /*** @UserCredentials **/
        postChangeCredentialsUser(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'new_password': [{min: 6}, {max: 191}],
                    'new_password_confirmation': [{min: 6}, {max: 191}],
                    'current_password': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/users/credentials-manage`, data, ajaxToken(c))
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
        /*** @UserCredentials **/
        /***  @UsersSettings Profile **/
        /*** @DashboardData **/
        fetchDashboardData(c, d) {
            c.commit('setValidated', {errors: {loading_dashboard_data: true}});
            client.get(`${apiUrl}/users/dashboard-data`, ajaxToken(c))
                .then(res => {
                    c.commit('setClearMsg');
                    c.commit('setDashboardData', res.data.data);
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @DashboardData **/
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
        /***@postChangeSignUpVolunteeringStatus */
        postChangeSignUpVolunteeringStatus(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data.data, {
                    'selectedStatus': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/users/volunteering-signup/change-status/${data.id}`, data.data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /***@postChangeSignUpVolunteeringStatus */
        manageVolunteeringActivityData(c, data) {
            let filters = '';
            for (let filter in data.filters) {
                if (data.filters.hasOwnProperty(filter)) {
                    filters += `&${filter}=${data.filters[filter] || ''}`;
                }
            }
            let request = `&limit=${data.limit || 6}&page=${data.page || 1}&q=${data.q || ''}${filters}`;
            c.commit('setValidated', {errors: {loading_volunteering_searches: true}});
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/volunteering-activity-manager/${data.id || 0}?tab=${data.tab}${request}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        manageVolunteeringActivityStatusData(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data.data, {
                    'status': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/users/volunteering-activity-manager-change-status/${data.id}`, data.data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /***@VolunteeringActivityData */
        /***@VolunteeringSignUpActivityMangeData */
        manageVolunteeringSignUpStatus(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data.data, {
                    'status': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/users/volunteering-signup/change-status/${data.id}`, data.data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        manageAllVolunteeringSignUpStatus(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/users/volunteering-signup/all-change-status`, {data: data.data}, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        manageAllVolunteeringSignUpAttendance(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/users/volunteering-signup/all-change-attendance`, {data: data.data}, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /***@VolunteeringSignUpActivityMangeData */
    }
};
