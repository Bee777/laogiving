webpackJsonp([2],{"5ekz":function(t,e,a){var n=a("Ngxa");"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var o=a("rjj0").default;o("3e93b00c",n,!0,{})},"6Gzr":function(t,e,a){"use strict";function n(t){a("Y2Ff")}Object.defineProperty(e,"__esModule",{value:!0});var o=a("VkuA"),r=a("Y0fY"),s=a("XyMi"),i=n,c=Object(s.a)(o.a,r.a,r.b,!1,i,null,null);e.default=c.exports},"8pqx":function(t,e,a){"use strict";var n=a("Dd8w"),o=a.n(n),r=a("nA46"),s=a("NYxO");e.a=r.a.extend({props:{isFullWidth:{default:!1}},data:function(){return{contactInfo:{header_title:"Contact Us Now"}}},methods:o()({},Object(s.b)(["postSendContact"]),{sendContact:function(){var t=this,e=this.contactInfo;return this.validated().loading_send_contact?void(e.header_title="Sending Information..."):void this.postSendContact(e).then(function(e){e.success&&(t.contactInfo={header_title:"Sent the information!"},setTimeout(function(){t.contactInfo={header_title:"Contact Us Now"}},3500))}).catch(function(t){t&&!t.errors&&(e.header_title="Failed to send the information!")})}})})},DvQe:function(t,e,a){"use strict";function n(t){a("5ekz")}var o=a("8pqx"),r=a("lrfK"),s=a("XyMi"),i=n,c=Object(s.a)(o.a,r.a,r.b,!1,i,"data-v-13d7720a",null);e.a=c.exports},Ngxa:function(t,e,a){e=t.exports=a("FZ+f")(),e.push([t.i,"",""])},VkuA:function(t,e,a){"use strict";var n=a("nA46"),o=a("DvQe");e.a=n.a.extend({components:{ContactForm:o.a},created:function(){this.setPageTitle("Contact Us")}})},Y0fY:function(t,e,a){"use strict";a.d(e,"a",function(){return n}),a.d(e,"b",function(){return o});var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{},[a("section",{staticClass:"contact"},[a("div",{staticClass:"container"},[t._m(0),t._v(" "),a("div",{staticClass:"row"},[a("div",{staticClass:"contact-content"},[a("div",{staticClass:"col-xs-12 col-sm-5 col-md-5 col-lg-5"},[a("div",{},[a("h3",{staticClass:"h3 dark"},[t._v("Get in touch with us")]),t._v(" "),a("p",[t._v("Got a cool idea, feedback on how we can improve or maybe just to say hi?")]),t._v(" "),a("p",[t._v("We'd love to hear from you! Please drop us an email at below.")]),t._v(" "),a("div",{staticClass:"con-icon"},[a("h3",{staticClass:"h3"},[a("i",{staticClass:"fas fa-phone"}),t._v("\n                                    "+t._s(t.s.phone)+"\n                                ")]),t._v(" "),a("h3",{staticClass:"h3"},[a("i",{staticClass:"fas fa-envelope"}),t._v("\n                                    "+t._s(t.s.email)+"\n                                ")]),t._v(" "),a("h3",{staticClass:"h3"},[a("i",{staticClass:"fas fa-map-marker-alt"}),t._v("\n                                    "+t._s(t.s.address)+"\n                                ")])])])]),t._v(" "),a("div",{staticClass:"col-xs-12 col-sm-7 col-md-7 col-lg-7"},[a("ContactForm",{attrs:{isFullWidth:!0}})],1)])]),t._v(" "),a("div",{staticClass:"map"},[a("iframe",{attrs:{src:t.s.google_map,frameborder:"0",scrolling:"no",marginheight:"0",marginwidth:"0"}})])])])])},o=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"title section-heading"},[a("h3",{staticClass:"h3 entry-title dark"},[t._v("Contact us")])])}]},Y2Ff:function(t,e,a){var n=a("lAm8");"string"==typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var o=a("rjj0").default;o("4d972ff4",n,!0,{})},lAm8:function(t,e,a){e=t.exports=a("FZ+f")(),e.push([t.i,".section-container{padding:6rem 0 3rem}.contact{padding:8px .9rem 42px;background:#edf3f5}.contact .general-from-container{min-height:100%;height:100%}.title{font-size:24px;margin-top:15px}input.general-input{border:none}.general-from-container:after,.general-from-container:before{height:0;content:none}.form-represent-form-container .field .control textarea{box-shadow:none;box-shadow:unset;display:block;max-width:100%;min-width:100%;padding:.625em;resize:vertical;border-radius:4px;border:1px solid #dadce0}.form-represent-form-container .field .control textarea:hover{border:1px solid #dadce0}.form-represent-form-container .field .control textarea:focus{border:2px solid #1a73e8;padding:.825em;outline:none}.form-represent-form-container .textarea:not([rows]){max-height:600px;min-height:120px}input[type=email]:focus,input[type=password]:focus,input[type=search]:focus,input[type=text]:focus,input[type=url]:focus,textarea:focus{border:none}.contact button.button-contact.contact-button{background-color:#1a73e8;margin-top:20px}.button-contact{background-color:#fff;border-color:#dbdbdb;border-width:1px;color:#363636;cursor:pointer;justify-content:center;text-align:center;white-space:nowrap;border:1px solid transparent;border-radius:4px;box-shadow:none}.button-contact.is-fullwidth{display:flex;width:100%}.button-contact.is-large{font-size:1.5rem}.button-contact.is-info{background-color:#209cee;border-color:transparent;color:#fff}button.button-contact:focus,button.button-contact:hover,input[type=button].button-contact:focus,input[type=button].button-contact:hover,input[type=reset].button-contact:focus,input[type=reset].button-contact:hover,input[type=submit].button-contact:focus,input[type=submit].button-contact:hover{color:#fff!important;border:1px solid transparent}.contact .form-represent.is-65{min-height:0}.contact .form-represent{flex-shrink:0;background:#fff;border-radius:8px;box-shadow:none;display:block;margin:0 auto;min-height:0;width:450px;border:1px solid #dadce0}.con-icon{padding:8px .9rem 42px;background:#edf3f5}.form-represent-form-container .field .control textarea.is-error{border:2px solid #d93025}.map{padding:6px 6px 0;border-radius:8px;border:1px solid #dadce0;background-color:#fff;margin-top:1.45rem}.map>iframe{width:100%;height:400px}",""])},lrfK:function(t,e,a){"use strict";a.d(e,"a",function(){return n}),a.d(e,"b",function(){return o});var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"general-from-container is-65"},[a("div",{staticClass:"form-represent is-65",style:(t.isFullWidth?"width: 100%":"")+";"},[a("div",{staticClass:"form-represent-top-border form-represent-top-border-z-index",attrs:{"aria-hidden":"true"}},[a("div",{staticClass:"form-represent-top-border-progress",class:[t.validated().loading_send_contact?"":"is-hide"]},[a("div",{staticClass:"form-represent-top-border-progress-img form-represent-top-border-progress-bg-size"}),t._v(" "),a("div",{staticClass:"form-represent-top-border-progress-tran"}),t._v(" "),t._m(0),t._v(" "),t._m(1)])]),t._v(" "),a("div",{staticClass:"form-represent-form-container"},[a("div",{staticClass:"form-represent-form-elements-container"},[a("div",{staticClass:"form-represent-form-header-caption"},[a("div",{staticClass:"header-text-centered"},[a("h1",{staticClass:"headingText"},[a("content",[t._v(t._s(t.contactInfo.header_title))])])])]),t._v(" "),a("div",[a("div",{staticClass:"form-represent-form-elements-container-inner"},[a("div",{staticClass:"form-represent-form-input"},[a("div",{},[a("content",[a("section",{staticClass:"section-input"},[a("div",{staticClass:"section-input-container-inner"},[a("div",{staticClass:"form-represent-form-container"},[a("content",[a("GeneralInput",{attrs:{inputType:"text",labelText:"Name",validate:{text:t.validated().name}},model:{value:t.contactInfo.name,callback:function(e){t.$set(t.contactInfo,"name",e)},expression:"contactInfo.name"}}),t._v(" "),a("GeneralInput",{attrs:{inputType:"email",labelText:"Email",validate:{text:t.validated().email}},model:{value:t.contactInfo.email,callback:function(e){t.$set(t.contactInfo,"email",e)},expression:"contactInfo.email"}}),t._v(" "),a("div",{staticClass:"field"},[a("div",{staticClass:"control"},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.contactInfo.message,expression:"contactInfo.message"}],staticClass:"textarea is-medium",class:[{"is-error":t.validated().message}],attrs:{placeholder:"Message"},domProps:{value:t.contactInfo.message},on:{input:function(e){e.target.composing||t.$set(t.contactInfo,"message",e.target.value)}}})]),t._v(" "),t.validated().message?a("div",{staticClass:"general-input-validate-container"},[a("div",{staticClass:"general-input-validate-top"}),t._v(" "),a("div",{staticClass:"general-input-validate-text-container"},[a("div",{staticClass:"inner"},[a("span",{staticClass:"span-icon"},[a("svg",{attrs:{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",viewBox:"0 0 24 24",fill:"rgb(229, 28, 35)"}},[a("path",{attrs:{d:"M0 0h24v24H0z",fill:"none"}}),a("path",{attrs:{d:"M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"}})])]),t._v(t._s(t.validated().message)+"\n                                                                ")])])]):t._e()])],1),t._v(" "),a("button",{staticClass:"button-contact is-info is-fullwidth is-large contact-button",attrs:{disabled:t.validated().loading_send_contact},on:{click:t.sendContact}},[t._v("\n                                                    Contact Us\n                                                ")])])])])])])])])])])])])])},o=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"form-represent-top-border-progress-tran-anim is-anim"},[a("span",{staticClass:"form-represent-top-border-progress-tran-anim-spot is-anim"})])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"form-represent-top-border-progress-tran-relay-anim is-anim"},[a("span",{staticClass:"form-represent-top-border-progress-tran-anim-spot scale is-anim"})])}]}});
//# sourceMappingURL=general.2.d4f8e314c08cd4f59952.js.map