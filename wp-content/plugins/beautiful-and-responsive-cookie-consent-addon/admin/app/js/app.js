(function(e){function t(t){for(var n,s,o=t[0],c=t[1],l=t[2],d=0,v=[];d<o.length;d++)s=o[d],Object.prototype.hasOwnProperty.call(a,s)&&a[s]&&v.push(a[s][0]),a[s]=0;for(n in c)Object.prototype.hasOwnProperty.call(c,n)&&(e[n]=c[n]);u&&u(t);while(v.length)v.shift()();return i.push.apply(i,l||[]),r()}function r(){for(var e,t=0;t<i.length;t++){for(var r=i[t],n=!0,o=1;o<r.length;o++){var c=r[o];0!==a[c]&&(n=!1)}n&&(i.splice(t--,1),e=s(s.s=r[0]))}return e}var n={},a={app:0},i=[];function s(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,s),r.l=!0,r.exports}s.m=e,s.c=n,s.d=function(e,t,r){s.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},s.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},s.t=function(e,t){if(1&t&&(e=s(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(s.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)s.d(r,n,function(t){return e[t]}.bind(null,n));return r},s.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="/";var o=window["webpackJsonp"]=window["webpackJsonp"]||[],c=o.push.bind(o);o.push=t,o=o.slice();for(var l=0;l<o.length;l++)t(o[l]);var u=c;i.push([0,"chunk-vendors"]),r()})({0:function(e,t,r){e.exports=r("56d7")},"56d7":function(e,t,r){"use strict";r.r(t);r("e260"),r("e6cf"),r("cca6"),r("a79d");var n=r("2b0e"),a=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("v-app",{staticStyle:{background:"#f0f0f1"}},[e.unsavedChanges?r("v-alert",{attrs:{dense:"",type:"warning"}},[e._v(' Unsaved changes. Please hit the "Save Changes" button to save them.')]):e._e(),r("v-overlay",{attrs:{opacity:"0.8",value:e.overlay}}),r("v-tabs",{staticStyle:{background:"#f0f0f1"},attrs:{centered:""}},[r("v-tab",[e._v(" Rules ")]),r("v-tab",[e._v(" Service List ")]),r("v-tab",[e._v(" How it works ")]),r("v-tab-item",{staticStyle:{background:"#f0f0f1"}},[r("ServicesSelect",{on:{unsavedchanged:function(t){e.unsavedChanges=!0}}})],1),r("v-tab-item",{staticStyle:{background:"#f0f0f1"}},[r("ServicesOverview")],1),r("v-tab-item",{staticStyle:{background:"#f0f0f1"}},[r("ServicesHowItWorks",{on:{unsavedchanged:function(t){e.unsavedChanges=!0}}})],1)],1)],1)},i=[],s=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("v-container",[r("v-row",[r("v-col",{attrs:{align:"center"}},[r("div",{staticClass:"text-h6"},[e._v("Service")])]),r("v-col",{attrs:{align:"center"}},[r("div",{staticClass:"text-h6"},[e._v("Allowed with consent")])]),r("v-col",{attrs:{cols:"1"}},[r("v-spacer")],1)],1),e._l(e.currentServicesSettings,(function(t,n){return r("v-row",{key:n},[r("v-col",[r("v-autocomplete",{attrs:{items:e.serviceItems,rules:[],filled:"",solo:"","hide-selected":""},on:{change:function(r){return e.saveNewValues(t.serviceId)}},model:{value:t.serviceId,callback:function(r){e.$set(t,"serviceId",r)},expression:"currentSetting.serviceId"}})],1),r("v-col",[r("v-autocomplete",{attrs:{items:e.consentCategories,filled:"",multiple:"",solo:""},on:{change:function(r){return e.saveNewValues(t.allowedWithConsents)}},model:{value:t.allowedWithConsents,callback:function(r){e.$set(t,"allowedWithConsents",r)},expression:"currentSetting.allowedWithConsents"}})],1),r("v-col",{attrs:{cols:"1"}},[r("v-icon",{staticClass:"pt-4",attrs:{small:""},on:{click:function(t){return e.deleteItem(n)}}},[e._v(" mdi-delete ")])],1)],1)})),r("v-row",[r("v-col",[r("v-btn",{attrs:{elevation:"0",small:"",outlined:"",raised:"",color:"#2271b1"},on:{click:function(t){return e.addItem()}}},[e._v(" Add a Rule ")])],1)],1)],2)},o=[],c=(r("d81d"),r("b0c0"),r("4de4"),r("1da1"));r("b64b"),r("d3b7"),r("99af"),r("96cf");function l(){return window.parent.document.getElementById("ff_nsc_bar_blocked_services")}function u(){var e=l();if(!e)return console.warn("element not found"),[];var t,r=[{allowedWithConsents:[],serviceId:""}];try{t=JSON.parse(e.value)||r}catch(n){t=r}return t}function d(e){return v.apply(this,arguments)}function v(){return v=Object(c["a"])(regeneratorRuntime.mark((function e(t){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,S("beautiful-and-responsive-cookie-consent/v1/customServices","POST",t);case 2:case"end":return e.stop()}}),e)}))),v.apply(this,arguments)}function f(e,t){var r;if("currentServicesSettings"===t){if(!Array.isArray(e))return console.warn("saveSettings: no array submitted!",e),!1;r=l()}if(!r)return console.error("needed element for type: ".concat(t," not found. This would have been stored:"),e),!1;r.value=JSON.stringify(e)}function h(){var e=window.parent.nsc_bara_available_consent_categories;return e||(console.warn("no consent cats found. will return fallback!"),[])}function m(){var e=window.parent.document.getElementById("ff_nsc_bar_activate_service_blocking");return!(!e||!e.checked||e.disabled)}function p(){var e=window.parent.nsc_bara_services_list;return e||(console.warn("no avalServiceList found. will return fallback!"),[])}function g(){return b.apply(this,arguments)}function b(){return b=Object(c["a"])(regeneratorRuntime.mark((function e(){var t,r,n,a,i;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,S("beautiful-and-responsive-cookie-consent/v1/customServices","GET",void 0);case 2:if(t=e.sent,console.log(t),200===t.status){e.next=7;break}return console.error("no customservices found.Need to abort!"),e.abrupt("return",!1);case 7:return e.next=9,t.json();case 9:for(r=e.sent,console.log(r),n=Object.keys(r),a=[],i=0;i<n.length;i+=1)a.push(r[n[i]]);return e.abrupt("return",a);case 15:case"end":return e.stop()}}),e)}))),b.apply(this,arguments)}function S(e,t,r){return w.apply(this,arguments)}function w(){return w=Object(c["a"])(regeneratorRuntime.mark((function e(t,r,n){var a,i,s,o;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return a=new Headers,a.append("Content-Type","application/json"),a.append("_wpnonce",window.nonce),a.append("X-WP-Nonce",window.nonce),i={method:r,headers:a,redirect:"follow"},"POST"===i.method&&(s=JSON.stringify(n),i.body=s),e.next=8,fetch("".concat(window.restURL).concat(t),i);case 8:return o=e.sent,e.abrupt("return",o);case 10:case"end":return e.stop()}}),e)}))),w.apply(this,arguments)}var x={name:"ServicesSelect",components:{},data:function(){return{currentServicesSettings:[],availableServiceList:[],availableConsentCategories:[],choosenCategorie:"",rules:{min:function(e){return e.length>=8||"Min 8 characters"}}}},computed:{chosenServicesId:function(){return this.currentServicesSettings.map((function(e){return e.serviceId}))},serviceItems:function(){return this.availableServiceList.map((function(e){return{text:e.serviceName,value:e.serviceId}}))},consentCategories:function(){return this.availableConsentCategories.map((function(e){return{text:e.name,value:e.nameId}}))}},mounted:function(){this.refreshValues()},methods:{refreshValues:function(){this.currentServicesSettings=u(),this.availableServiceList=p(),this.availableConsentCategories=h()},testAllFieldsFilled:function(){for(var e=0;e<this.currentServicesSettings.length;e+=1)if(!this.currentServicesSettings[e].serviceId||!this.currentServicesSettings[e].allowedWithConsents||0===this.currentServicesSettings[e].allowedWithConsents.length)return!1;return!0},deleteItem:function(e){delete this.currentServicesSettings[e],this.currentServicesSettings=this.currentServicesSettings.filter(Boolean),this.saveNewValues()},addItem:function(){this.currentServicesSettings.push({allowedWithConsents:[],serviceId:""})},saveNewValues:function(){this.testAllFieldsFilled()&&(f(this.currentServicesSettings,"currentServicesSettings"),this.$emit("unsavedchanged",!0))}}},y=x,I=r("2877"),_=r("6544"),k=r.n(_),C=r("c6a6"),O=r("8336"),V=r("62ad"),j=r("a523"),P=r("132d"),T=r("0fd9"),N=r("2fa4"),E=Object(I["a"])(y,s,o,!1,null,null,null),R=E.exports;k()(E,{VAutocomplete:C["a"],VBtn:O["a"],VCol:V["a"],VContainer:j["a"],VIcon:P["a"],VRow:T["a"],VSpacer:N["a"]});var A=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("v-container",[r("v-card",[r("v-card-title",[r("v-text-field",{attrs:{"append-icon":"mdi-magnify",label:"Search","single-line":"","hide-details":""},model:{value:e.search,callback:function(t){e.search=t},expression:"search"}})],1),r("v-data-table",{attrs:{headers:e.headers,items:e.services,search:e.search,"sort-by":["type","serviceName"],"sort-desc":[!0,!1],"footer-props":{itemsPerPageOptions:[10,20,50,100,-1]}},scopedSlots:e._u([{key:"top",fn:function(){return[r("v-toolbar",{attrs:{flat:""}},[r("v-toolbar-title",[e._v("Services")]),r("v-spacer"),r("v-dialog",{attrs:{"max-width":"500px"},scopedSlots:e._u([{key:"activator",fn:function(t){var n=t.on,a=t.attrs;return[r("v-btn",e._g(e._b({staticClass:"mb-2",attrs:{color:"primary",dark:""}},"v-btn",a,!1),n),[e._v(" Add Service ")])]}}]),model:{value:e.dialog,callback:function(t){e.dialog=t},expression:"dialog"}},[r("v-card",[r("v-card-title",[r("span",{staticClass:"headline"},[e._v(e._s(e.formTitle))])]),r("v-card-text",[r("v-container",[r("v-row",[r("v-col",{attrs:{cols:"12",sm:"12",md:"12"}},[r("v-text-field",{attrs:{label:"Service Name"},model:{value:e.editedItem.serviceName,callback:function(t){e.$set(e.editedItem,"serviceName",t)},expression:"editedItem.serviceName"}})],1)],1),r("v-row",[r("v-col",{attrs:{cols:"12",sm:"12",md:"12"}},[r("v-text-field",{attrs:{label:"Regex"},model:{value:e.editedItem.regExPattern,callback:function(t){e.$set(e.editedItem,"regExPattern",t)},expression:"editedItem.regExPattern"}})],1)],1)],1),e.dialogError?r("v-alert",{attrs:{dense:"",type:"error"}},[e._v(" "+e._s(e.dialogError)+" ")]):e._e(),r("v-alert",{attrs:{dense:"",outlined:"",type:"info"}},[e._v(" Be careful! Use this function only if you know what you are doing and test your settings on a test environment first! ")])],1),r("v-card-actions",[r("v-spacer"),r("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:e.close}},[e._v(" Cancel ")]),r("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:e.save}},[e._v(" Save ")])],1)],1)],1),r("v-dialog",{attrs:{"max-width":"500px"},model:{value:e.dialogDelete,callback:function(t){e.dialogDelete=t},expression:"dialogDelete"}},[r("v-card",[r("v-card-title",{staticClass:"headline"},[e._v("Are you sure you want to delete this item?")]),r("v-card-actions",[r("v-spacer"),r("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:e.closeDelete}},[e._v("Cancel")]),r("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:e.deleteItemConfirm}},[e._v("OK")]),r("v-spacer")],1)],1)],1)],1)]},proxy:!0}])})],1)],1)},D=[],W=(r("a434"),r("5319"),r("ac1f"),r("caad"),r("2532"),{name:"ServicesOverview",components:{},data:function(){return{search:"",headers:[{text:"Service Name",align:"start",value:"serviceName"},{text:"Identifier Regex",value:"regExPattern"},{text:"Type",value:"type"}],services:p(),customServices:!1,dialogError:"",dialog:!1,dialogDelete:!1,formTitle:"Add a new service",editedIndex:-1,defaultItem:{serviceName:"",regExPattern:"",type:"Custom"},editedItem:{serviceName:"",regExPattern:"",type:"Custom"}}},computed:{customServicesIds:function(){return!!this.customServices&&this.customServices.map((function(e){return e.serviceId}))}},mounted:function(){var e=this;return Object(c["a"])(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,g();case 2:e.customServices=t.sent,console.log(e.customServices);case 4:case"end":return t.stop()}}),t)})))()},methods:{editItem:function(e){this.editedIndex=this.customServices.indexOf(e),this.editedItem=Object.assign({},e),this.dialog=!0},deleteItem:function(e){this.editedIndex=this.customServices.indexOf(e),this.editedItem=Object.assign({},e),this.dialogDelete=!0},deleteItemConfirm:function(){this.customServices.splice(this.editedIndex,1),this.closeDelete()},close:function(){var e=this;this.dialog=!1,this.dialogError="",this.$nextTick((function(){e.editedItem=Object.assign({},e.defaultItem),e.editedIndex=-1}))},closeDelete:function(){var e=this;this.dialogDelete=!1,this.dialogError="",this.$nextTick((function(){e.editedItem=Object.assign({},e.defaultItem),e.editedIndex=-1}))},save:function(){if(this.editedItem.serviceName&&this.editedItem.regExPattern)if(this.customServices){if(!this.editedItem.serviceId){var e="cust".concat(this.editedItem.serviceName.replace(/[^A-Za-z0-9]/g,""));if(this.customServicesIds.includes(e))return void(this.dialogError="Service name already taken. Please choose a different one.");this.editedItem.serviceId=e}this.editedIndex>-1?Object.assign(this.customServices[this.editedIndex],this.editedItem):(this.services.push(this.editedItem),this.customServices.push(this.editedItem));for(var t={},r=0;r<this.customServices.length;r+=1)t[this.customServices[r].serviceId]=this.customServices[r];d(t,"customServices"),this.close()}else this.dialogError="There was a Problem getting the configured services. Maybe a reaload of the page helps.";else this.dialogError="Please provide a value for regex and service name."}}}),$=W,H=r("0798"),B=r("b0af"),J=r("99d9"),L=r("8fea"),M=r("169a"),F=r("8654"),U=r("71d9"),q=r("2a7f"),z=Object(I["a"])($,A,D,!1,null,null,null),G=z.exports;k()(z,{VAlert:H["a"],VBtn:O["a"],VCard:B["a"],VCardActions:J["a"],VCardText:J["b"],VCardTitle:J["c"],VCol:V["a"],VContainer:j["a"],VDataTable:L["a"],VDialog:M["a"],VRow:T["a"],VSpacer:N["a"],VTextField:F["a"],VToolbar:U["a"],VToolbarTitle:q["a"]});var K=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("v-container",[r("v-card",[r("v-card-title",[e._v(" How it works ")]),r("p",{staticClass:"text-justify mx-8"},[e._v("It blocks services in a 2-Step Process:")]),r("ol",{staticClass:"text-justify mx-8"},[r("li",[e._v('Removes all tags from the raw PHP Output with "Buffer"')]),r("li",[e._v(" It makes sure, that no JS which fit the regex can be injected dynamically by any JS after page load. ")])]),r("p",{staticClass:"text-justify px-8 pt-5"},[e._v(' It identifies the services with the regex from the "Service Details" Tab. If you are spotting an error or are missing a service please contact me at info@beautiful-cookie-banner.com. Needed Information: ')]),r("ul",{staticClass:"text-justify mx-8 pb-5"},[r("li",[e._v("Name of Service")]),r("li",[e._v("URL of Provider Homepage")]),r("li",[e._v(" If possible the needed Regex already or an example of the request to block ")])])],1)],1)},X=[],Z={name:"ServicesHowItWorks",components:{},data:function(){return{}}},Q=Z,Y=Object(I["a"])(Q,K,X,!1,null,null,null),ee=Y.exports;k()(Y,{VCard:B["a"],VCardTitle:J["c"],VContainer:j["a"]});var te={name:"App",components:{ServicesSelect:R,ServicesOverview:G,ServicesHowItWorks:ee},mounted:function(){m()?this.overlay=!1:this.overlay=!0},data:function(){return{overlay:!1,unsavedChanges:!1}}},re=te,ne=r("7496"),ae=r("a797"),ie=r("71a3"),se=r("c671"),oe=r("fe57"),ce=Object(I["a"])(re,a,i,!1,null,null,null),le=ce.exports;k()(ce,{VAlert:H["a"],VApp:ne["a"],VOverlay:ae["a"],VTab:ie["a"],VTabItem:se["a"],VTabs:oe["a"]});r("5363");var ue=r("f309");n["a"].use(ue["a"]);var de={icons:{iconfont:"mdi"}},ve=new ue["a"](de);n["a"].config.productionTip=!1,new n["a"]({vuetify:ve,render:function(e){return e(le)}}).$mount("#app")}});
//# sourceMappingURL=app.js.map