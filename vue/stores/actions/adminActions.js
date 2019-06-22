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
            let request = `limit=${i.limit}&page=${i.page}&q=${i.q}`;
            c.commit('setValidated', {errors: {loading_searches: true}});
            client.get(`${apiUrl}/admin/searches/${i.type}?${request}`, ajaxToken(c))
                .then(res => {
                    c.commit('setSearchesData', {type: i.type, data: res.data.data});
                    c.commit('setClearMsg');
                })
                .catch(err => {
                    c.commit('setClearMsg');
                    c.dispatch('HandleError', err.response);
                });
        },
        /***  @Users  **/
        postChangeUserStatus(c, i) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/users-change-status/${i.id}`, i.data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    })
            });
        },
        postDeleteUser(c, i) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/users-delete/${i.id}`, i.data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    })
            });
        },
        postRegisterUser(c, user) {
            return new Promise((r, n) => {
                utils.Validate(user, {
                    'name': ['required'],
                    'type': ['required'],
                    'email': ['email', 'required'],
                    'password': ['required', {min: 6}]
                }).then((v) => {
                    //directly add password confirmation  for admin
                    user.password_confirmation = user.password;
                    client.post(`${apiUrl}/admin/users-register`, user, ajaxConfig)
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
        /***  @Users  **/
        /*** @ContactInfo **/
        fetchContactInfo(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/contactinfo`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        postMangeContactInfo(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    phone: ["required", 'phone number'],
                    email: ["required", 'email'],
                    address: ["required"]
                }).then(v => {
                    client.post(`${apiUrl}/admin/contactinfo/manage`, data, ajaxToken(c))
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
        /*** @ContactInfo **/
        /*** @AboutInfo **/
        fetchAboutInfo(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/aboutinfo`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        postMangeAboutInfo(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/aboutinfo/manage`, data, ajaxToken(c))
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
        /*** @AboutInfo **/
        /*** @News **/
        postCreateNews(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'description'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/news/create`, formData, ajaxToken(c))
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
        postUpdateNews(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'description'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/news/update/${data.id}`, formData, ajaxToken(c))
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
        postDeleteNews(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/news/delete/${i.id}`, ajaxToken(c))
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
        /*** @News **/
        /*** @Activity **/
        postCreateActivity(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    place: ["required"],
                    activity_date: ["required"],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'activity_date'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/activity/create`, formData, ajaxToken(c, true))
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
        postUpdateActivity(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    place: ["required"],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    activity_date: ["required"],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'activity_date'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/activity/update/${data.id}`, formData, ajaxToken(c, true))
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
        postDeleteActivity(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/activity/delete/${i.id}`, ajaxToken(c))
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
        /*** @Activity **/
        /*** @OrganizeChartChartRange **/
        /*** @SiteInfo **/
        postManageSiteInfo(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'site_name': ['required', {max: 191}],
                    'website_logo': [{max: 2000}, {mimes: 'png,jpg,jpeg,svg'}],
                    'favorite_icon': [{max: 2000}, {mimes: 'png,jpg,jpeg,svg'}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['site_name'], formData, data);
                    if (data.website_logo) {
                        formData.append('website_logo', data.website_logo.file);
                    }
                    if (data.favorite_icon) {
                        formData.append('favorite_icon', data.favorite_icon.file);
                    }
                    client.post(`${apiUrl}/admin/site-info/manage`, formData, ajaxToken(c, true))
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
        getSiteInfo(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/site-info`, ajaxToken(c))
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
        /*** @SiteInfo **/
        /*** @SingleUserProfile **/
        fetchMemberProfile(c, user_id) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/profile-single/${user_id}`, ajaxToken(c))
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
        /*** @SingleUserProfile **/
        /*** @Banner **/
        postCreateBanner(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required", {max: 191}],
                    link: ["required", {max: 191}],
                    link_name: ["required", {max: 191}],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'link_name', 'order', 'link'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/banner/create`, formData, ajaxToken(c, true))
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
        postUpdateBanner(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required", {max: 191}],
                    link: ["required", {max: 191}],
                    link_name: ["required", {max: 191}],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'link_name', 'order', 'link'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/banner/update/${data.id}`, formData, ajaxToken(c, true))
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
        postDeleteBanner(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/banner/delete/${i.id}`, ajaxToken(c))
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
        /*** @Banner **/
        /*** @OptionDataUserProfile **/
        fetchOptionProfileData(c, data) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/profile-options`, ajaxToken(c))
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
        /*** @OptionDataUserProfile **/
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
        /*** @postSendUserResetPasswordLink **/
        postSendUserResetPasswordLink(c, i) {
            return new Promise((r, n) => {
                c.commit('setValidated', {errors: {loading_searches: true}});
                client.post(`${apiUrl}/admin/users-send-reset-password-link/${i.id}`, i.data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    })
            });
        },
        /*** @postSendUserResetPasswordLink **/
        /*** @postManagePostsStatus **/
        postManagePostsStatus(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    id: ["required", {max: 191}],
                    changeStatusTo: ["required", {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/admin/posts-status/manage`, data, ajaxToken(c))
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
        /*** @postManagePostsStatus **/
        /*** @postManageCategory**/
        postCreateCategory(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'name': ['required', {max: 191}],
                    'icon': ['required', {mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                    'background_image': ['required', {mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                }).then(v => {

                    let formData = new FormData();
                    utils.addDataForm(['name'], formData, data);
                    formData.append('icon', data.icon.file);
                    formData.append('background_image', data.background_image.file);

                    client.post(`${apiUrl}/admin/volunteering/category/create`, formData, ajaxToken(c, true))
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
        postUpdateCategory(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'name': ['required', {max: 191}],
                    'icon': [{mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                    'background_image': [{mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['name'], formData, data);
                    if (data.icon && data.icon.file) {//check if user change icon
                        formData.append('icon', data.icon.file);
                    }
                    if (data.background_image && data.background_image.file) {//check if user change background_image
                        formData.append('background_image', data.background_image.file);
                    }
                    client.post(`${apiUrl}/admin/volunteering/category/update/${data.id}`, formData, ajaxToken(c, true))
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
        postDeleteCategory(c, data) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/volunteering/category/delete/${data.id}`, ajaxToken(c))
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
        /*** @postManageCategory**/

        /*** @postManageSkill**/
        postCreateSkill(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'name': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/admin/volunteering/skill/create`, data, ajaxToken(c))
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
        postUpdateSkill(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'name': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/admin/volunteering/skill/update/${data.id}`, data, ajaxToken(c))
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
        postDeleteSkill(c, data) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/volunteering/skill/delete/${data.id}`, ajaxToken(c))
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
        /*** @postManageCategory**/
        /*** @postManageSuitable**/
        postCreateSuitable(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'name': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/admin/volunteering/suitable/create`, data, ajaxToken(c))
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
        postUpdateSuitable(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'name': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/admin/volunteering/suitable/update/${data.id}`, data, ajaxToken(c))
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
        postDeleteSuitable(c, data) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/volunteering/suitable/delete/${data.id}`, ajaxToken(c))
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
        /*** @postManageCategory**/
    }
};
