webpackJsonp([0],{KUW7:function(t,a,e){var s=e("LE1v");"string"==typeof s&&(s=[[t.i,s,""]]),s.locals&&(t.exports=s.locals);var o=e("rjj0").default;o("673b247b",s,!0,{})},LE1v:function(t,a,e){a=t.exports=e("FZ+f")(),a.push([t.i,".section-container{padding:6rem 0 3rem}.pop-out-enter-active,.pop-out-leave-active{transition:all .5s}.pop-out-enter,.pop-out-leave-active{opacity:0;transform:translateY(24px)}",""])},LZot:function(t,a,e){"use strict";a.a={name:"Modals",data:function(){return{modalNames:{login:"signin",signUpVolunteer:"volunteer-signup"},modalWidth:858}},watch:{"$route.path":function(){for(var t in this.modalNames)this.modalNames.hasOwnProperty(t)&&this.hide(this.modalNames[t],{close:!0})}},methods:{beforeOpen:function(){this.jq("html").addClass("hidden sidebar"),this.jq("body").addClass("hidden sidebar")},beforeClose:function(t){return"volunteer-signup"!==t.name||t.params&&t.params.close?(this.jq("body").removeClass("hidden sidebar"),void this.jq("html").removeClass("hidden sidebar")):void t.stop()},hide:function(t,a){this.$modal.hide(t,a)},loginForm:function(){this.jq('[data-toggle="tooltip"]').tooltip()},volunteerForm:function(){var t=this,a=this.$refs["volunteer-form"],e=a.clientHeight;setTimeout(function(){var s=t.jq("#volunteer-date-picker");s.on("mousedown",function(t){t.preventDefault()}),s.pickadate({selectMonths:!0,selectYears:80,formatSubmit:"yyyy-mm-dd",max:new Date,onOpen:function(){setTimeout(function(){var s=t.jq(".picker__holder").height();a.style.height=e+(s-26*s/100)+"px"},100)},onClose:function(){console.log(this.get("select","yyyy-mm-dd"))}})},300)}},created:function(){var t=this.jq(document).width();this.modalWidth=t-32<858?t-8*(t+32)/100:858}}},VBty:function(t,a,e){"use strict";function s(t){e("KUW7")}Object.defineProperty(a,"__esModule",{value:!0});var o=e("LZot"),i=e("ivRW"),n=e("XyMi"),r=s,l=Object(n.a)(o.a,i.a,i.b,!1,r,null,null);a.default=l.exports},ivRW:function(t,a,e){"use strict";e.d(a,"a",function(){return s}),e.d(a,"b",function(){return o});var s=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("modal",{attrs:{id:"signinmodal",transition:"nice-modal-fade",name:t.modalNames.login,classes:"modal-ctn",height:"auto"},on:{"before-open":t.beforeOpen,opened:t.loginForm,"before-close":t.beforeClose}},[e("div",{staticClass:"content-area"},[e("main",{staticClass:"site-main activity"},[e("div",{staticClass:"login-form form"},[e("h2",{staticClass:"h2 text-center mb-16"},[t._v("Login")]),t._v(" "),e("div",{staticClass:"cursor",on:{click:function(a){return t.hide("signin")}}},[e("i",{staticClass:"material-icons close-modal-ctn"},[t._v("close")])]),t._v(" "),e("div",{staticClass:"body-txt body-txt--smaller body-txt--no-letter-space pt-8 text-center"},[t._v("Your\n                        information is safe and secure with us.\n                    ")]),t._v(" "),e("form",{attrs:{name:"loginform",method:"post"},on:{submit:function(t){t.preventDefault()}}},[e("label",[t._v(" Email\n                            "),e("input",{attrs:{autocomplete:"username email",name:"email",value:"",type:"text"}})]),t._v(" "),e("label",[t._v("\n                            Password "),e("span",{staticClass:"tooltip__mark",attrs:{"data-toggle":"tooltip","data-placement":"right",title:"Your password must be between 8-24 characters with at least one number. Only special characters @$!%*?&+-.=^_|~ are accepted."}},[t._v("?")]),t._v(" "),e("input",{attrs:{autocomplete:"current-password",name:"password",value:"",type:"password"}})]),t._v(" "),e("label",{staticClass:"mb-16"},[e("a",[t._v("Forgot Password?")])]),t._v(" "),e("button",{staticClass:"button-ctn button--large button--full"},[t._v("Login")]),t._v(" "),e("p",{staticClass:"p-modal-footer"},[t._v(" Don't have an account? "),e("a",{staticClass:"cursor",on:{click:function(a){return t.Route({name:"register-overview"})}}},[t._v("Create an Account")]),t._v(" now! ")])])])])])]),t._v(" "),e("modal",{attrs:{id:"volunteer-signup-modal",transition:"pop-out",name:t.modalNames.signUpVolunteer,classes:"modal-ctn",width:t.modalWidth,height:"auto",scrollable:!0},on:{opened:t.volunteerForm,"before-open":t.beforeOpen,"before-close":t.beforeClose}},[e("div",{staticClass:"content-area"},[e("div",{staticClass:"site-main activity"},[e("div",{staticClass:"modal-header-ctn"},[e("div",{staticClass:"cursor",on:{click:function(a){return t.hide("volunteer-signup",{close:!0})}}},[e("i",{staticClass:"material-icons close-modal-ctn"},[t._v("close")])]),t._v(" "),e("h3",{staticClass:"h3"},[t._v(" ")])]),t._v(" "),e("div",{staticClass:"height-auto"},[e("div",{staticClass:"form"},[e("div",{staticClass:"modal-header-ctn"},[e("img",{staticClass:"profile-pic profile-pic--small mr-16",attrs:{src:"https://www.giving.sg/givingsg-theme/images/mt/ph-pink.jpg",id:"yui_patched_v3_11_0_1_1556981879776_1415"}}),t._v(" "),e("h4",{staticClass:"h2"},[t._v("Hello, Bee Organization")]),t._v(" "),e("p",{staticClass:"body-txt body-txt--small mb-16"},[t._v("You are signing up as "),e("b",[t._v("Individual")]),t._v(".")])]),t._v(" "),e("div",{staticClass:"rounded-card rounded-card--no-pad rounded-card--light-shadow rounded-card--height-auto",staticStyle:{"max-width":"100%","margin-left":"5px","margin-right":"5px"}},[e("div",{ref:"volunteer-form",staticClass:"rounded-card__body rounded-card__body--responsive"},[e("form",{staticClass:"activity",attrs:{method:"post"},on:{submit:function(t){t.preventDefault()}}},[e("div",{staticClass:"input-ctrl volunteer-activity-info"},[e("h3",{staticClass:"h3 font-dark-grey"},[t._v("Yes, I want to sign up as a")]),t._v(" "),e("h3",{staticClass:"h3 mt-16 font-dark-grey"},[t._v("Front of House")]),t._v(" "),e("h3",{staticClass:"h3 mt-16 font-dark-grey",staticStyle:{"font-weight":"normal"}},[t._v("for")]),t._v(" "),e("h3",{staticClass:"h3 mt-16 font-dark-grey"},[t._v("FOH Volunteers for TheatreWorks'\n                                            Production")]),t._v(" "),e("h3",{staticClass:"h3 mt-16 mb-16 font-dark-grey",staticStyle:{"font-weight":"normal"}},[t._v("\n                                            on")]),t._v(" "),e("h3",{staticClass:"h3 mb-16 font-dark-grey"},[t._v("21 May 2019 - 30 May 2019")]),t._v(" "),e("p",{staticClass:"body-txt mb-16"},[e("span",[e("b",[t._v("12:00 AM to 12:00 AM")])]),t._v(" "),e("br"),t._v(" "),e("br"),t._v("at\n                                            88 GEYLANG BAHRU ")])]),t._v(" "),e("hr",{staticClass:"hr"}),t._v(" "),e("div",{staticClass:"rounded-card rounded-card--plain rounded-card--reset-margin rounded-card--mt-16"},[e("div",{staticClass:"rounded-card__head rounded-card__head--white"},[e("h3",{staticClass:"h3 font-dark-grey"},[t._v("Points To Note")])]),t._v(" "),e("div",{staticClass:"rounded-card__body font-dark-grey"},[e("p",[t._v("We are looking for volunteers to help out with FOH duties such as\n                                                sale of programmes, answering enquires, and ushering. Volunteers\n                                                will also assist in carrying out other duties such as headphones\n                                                distributions, drinks services and managing sale of accessories.")]),t._v(" "),e("div",{staticClass:"mt-16"},[e("span",{staticClass:"bold"},[t._v("Your request will go through an approval process by our Volunteer Manager or Volunteer Leader")])])])]),t._v(" "),e("hr",{staticClass:"hr"}),t._v(" "),e("div",{staticClass:"input-ctrl"},[e("label",{staticClass:"lbl"},[e("h3",{staticClass:"h3 font-dark-grey font-16-tablet-portrait-down"},[t._v("Personal\n                                                details")]),t._v(" "),e("p",{staticClass:"body-txt body-txt--small mb-16"},[t._v("We need the following\n                                                details from you to sign up! ")])])]),t._v(" "),e("div",{staticClass:"input-ctrl"},[e("label",{staticClass:"lbl"},[t._v("Date of Birth\n                                        ")]),t._v(" "),e("input",{staticClass:"input-ctn",attrs:{id:"volunteer-date-picker",name:"date_of_birth","data-value":(new Date).getFullYear()+"/01/01",placeholder:"DD M, YYYY",maxlength:"10",type:"text",readonly:"","aria-haspopup":"true","aria-expanded":"false","aria-readonly":"false","aria-owns":"date_of_birth"}})]),t._v(" "),e("div",{staticClass:"input-ctrl"},[e("label",{staticClass:"lbl"},[t._v("Contact Number\n                                        ")]),t._v(" "),e("input",{staticClass:"input-ctn",attrs:{type:"text",placeholder:"",name:"contactNumber",value:"030984832"}})])])]),t._v(" "),e("div",{staticClass:"create-volunteer-act__footer",staticStyle:{"margin-top":"80px!important","text-align":"center"}},[e("button",{staticClass:"button-ctn button--135 button--large join-volunteer-button"},[t._v("JOIN\n                                ")])])])])])])])])],1)},o=[]}});
//# sourceMappingURL=organize.0.0328bb52aef07cd5f473.js.map