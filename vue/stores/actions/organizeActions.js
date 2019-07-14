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
        /***  @UsersSettings Profile **/
        /*** @UserProfile **/
        fetchOptionProfileData(c, data) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/profile-options?type=organize`, ajaxToken(c))
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
        postManageVisibilityUserProfile(c, data) {
            return new Promise((r, n) => {
                let info = utils.clone(data);
                //visibility
                info.visibility = info.visibility === true ? 'visible' : 'hidden';
                client.post(`${apiUrl}/users/visibility-profile-manage`, info, ajaxToken(c))
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
                    'user_causes': ['required'],
                    'contact_person': [{max: 191}],
                    'facebook': [{max: 191}],
                    'website': [{max: 191}],
                    'about': [{max: 1500}]
                }).then(v => {
                    let info = utils.clone(data);
                    for (let i in info) {
                        if (info.hasOwnProperty(i)) {
                            if (utils.isEmptyVar(info[i])) {
                                info[i] = '';
                            }
                        }
                    }
                    //visibility
                    info.visibility = info.visibility === true ? 'visible' : 'hidden';
                    //form data
                    let formData = new FormData();
                    utils.addDataForm([
                        'display_name',
                        'registration_date',
                        'group_size',
                        'visibility',
                        'contact_person',
                        'public_email',
                        'phone_number',
                        'address',
                        'facebook',
                        'website',
                        'vision_mission',
                        'our_programmes',
                        'about',
                    ], formData, info);
                    //user causes
                    (info.user_causes || []).map((i) => {
                        formData.append('user_causes[]', i);
                    });

                    //user media
                    let video = info.user_media.video;
                    if (!utils.isEmptyVar(video.url)) {
                        formData.append('user_media_video_url', video.url);
                    }
                    let images = info.user_media.images;
                    images.map((i) => {
                        if (i.clear && i.id) {
                            formData.append('user_media_images_cleared[]', i.id);
                        } else if (i.id && i.url && !i.change) {
                            formData.append('user_media_images[]', new File([""], i.url));
                        } else {
                            utils.Validate(i, {
                                'image': ['required', {mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                            }).then(v => {
                                formData.append('user_media_images[]', i.image.file);
                            }).catch(e => {

                            });
                        }
                    });
                    //user profile image
                    if (info.profile_image) {//check if user change image
                        formData.append('profile_image', info.profile_image.file);
                    }

                    client.post(`${apiUrl}/users/profile-manage?type=organize`, formData, ajaxToken(c, true))
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
                    'new_email': ['email', {max: 191}],
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
            let minYear = 2015;
            c.commit('setValidated', {errors: {loading_dashboard_data: true}});
            let filters = d.filters, request = '';
            if (filters.filter === 'customMonth') {
                request = `?fromMonths=${filters.from.monthFilter}&fromYears=${filters.from.yearFilter}&toMonths=${filters.to.monthFilter}&toYears=${filters.to.yearFilter}`
                if (filters.from.yearFilter < minYear) {
                    c.commit('setValidated', {errors: {custom_date_range: true}});
                    return;
                }
                if (filters.from.yearFilter > filters.to.yearFilter) {
                    c.commit('setValidated', {errors: {custom_date_range: true}});
                    return;
                }
                if (filters.from.yearFilter === filters.to.yearFilter && (filters.from.monthFilter > filters.to.monthFilter)) {
                    c.commit('setValidated', {errors: {custom_date_range: true}});
                    return;
                }
            } else {
                request = `?selectMonths=${filters.filter}`
            }
            client.get(`${apiUrl}/users/dashboard-data${request}`, ajaxToken(c))
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
        /***@VolunteeringActivityData */
        fetchVolunteeringActivityData(c, data) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/volunteering-activity-options?activity_id=${(data.id || '')}`, ajaxToken(c))
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
        saveVolunteeringActivityData(c, formData) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/users/volunteering-activity-create`, formData, ajaxToken(c, true))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        let res = err.response
                        if (res && res.data && res.data.errors) {
                            c.dispatch('showErrorToast', {
                                msg: 'Something went wrong with your volunteering information!.',
                                dt: 3500
                            });
                        }
                        n(err.response);
                    });
            });
        },
        updateVolunteeringActivityData(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/users/volunteering-activity-update/${data.id}`, data.data, ajaxToken(c, true))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        let res = err.response
                        if (res && res.data && res.data.errors) {
                            c.dispatch('showErrorToast', {
                                msg: 'Something went wrong with your volunteering information!.',
                                dt: 3500
                            });
                        }
                        n(err.response);
                    });
            });
        },
        discardVolunteeringActivityData(c, data) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/users/volunteering-activity-discard/${data.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    });
            });
        },
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
        /***@VolunteeringSignUpActivityData */
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
        fetchAllVolunteers(c, data) {
            return new Promise((r, n) => {
                let filters = '';
                for (let filter in data.filters) {
                    if (data.filters.hasOwnProperty(filter)) {
                        filters += `&${filter}=${data.filters[filter] || ''}`;
                    }
                }
                c.commit('setValidated', {errors: {loading_all_volunteers: true}});
                let request = `&limit=${data.limit || 6}&page=${data.page || 1}&q=${data.q || ''}${filters}`;
                client.get(`${apiUrl}/users/volunteering-fetch-all-volunteers?${request}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        }
        /***@VolunteeringSignUpActivityData */
    }
};
