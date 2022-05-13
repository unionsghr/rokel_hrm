! function () {
  return function e(t, a, i) {
    function l(r, o) {
      if (!a[r]) {
        if (!t[r]) {
          var s = "function" == typeof require && require;
          if (!o && s) return s(r, !0);
          if (n) return n(r, !0);
          var u = new Error("Cannot find module '" + r + "'");
          throw u.code = "MODULE_NOT_FOUND", u
        }
        var c = a[r] = {
          exports: {}
        };
        t[r][0].call(c.exports, function (e) {
          return l(t[r][1][e] || e)
        }, c, c.exports, e, t, a, i)
      }
      return a[r].exports
    }
    for (var n = "function" == typeof require && require, r = 0; r < i.length; r++) l(i[r]);
    return l
  }
}()({
  1: [function (e, t, a) {
    "use strict";
    Object.defineProperty(a, "__esModule", {
      value: !0
    });
    var i = function () {
      function e(e, t) {
        for (var a = 0; a < t.length; a++) {
          var i = t[a];
          i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
        }
      }
      return function (t, a, i) {
        return a && e(t.prototype, a), i && e(t, i), t
      }
    }();
    var l = function () {
      function e() {
        ! function (e, t) {
          if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }(this, e)
      }
      return i(e, [{
        key: "getKey",
        value: function (e, t) {
          var a = e + "|";
          for (var i in t) a += i + "=" + t[i] + "|";
          return a
        }
      }, {
        key: "invalidateTable",
        value: function (e) {
          for (var t = void 0, a = 0; a < localStorage.length; a++)(t = localStorage.key(a)).indexOf("t=" + e) > 0 && localStorage.removeItem(t)
        }
      }, {
        key: "getData",
        value: function (e) {
          var t = void 0;
          if ("undefined" == typeof Storage) return null;
          var a = localStorage.getItem(e);
          return void 0 !== a && null != a && "" !== a ? void 0 === (t = JSON.parse(a)) || null == t ? null : void 0 !== t.status && null != t.status && "SUCCESS" !== t.status ? null : t : null
        }
      }, {
        key: "setData",
        value: function (e, t) {
          if ("undefined" == typeof Storage) return null;
          if (void 0 !== t.status && null != t.status && "SUCCESS" !== t.status) return null;
          var a = JSON.stringify(t);
          return localStorage.setItem(e, a), a
        }
      }]), e
    }();
    a.default = l
  }, {}],
  2: [function (e, t, a) {
    "use strict";
    Object.defineProperty(a, "__esModule", {
      value: !0
    });
    var i = function () {
      function e(e, t) {
        for (var a = 0; a < t.length; a++) {
          var i = t[a];
          i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
        }
      }
      return function (t, a, i) {
        return a && e(t.prototype, a), i && e(t, i), t
      }
    }(),
      l = r(e("./ModuleBase")),
      n = r(e("../api-common/RequestCache"));

    function r(e) {
      return e && e.__esModule ? e : {
        default: e
      }
    }
    var o = function (e) {
      function t(e, a, i, l) {
        ! function (e, t) {
          if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }(this, t);
        var n = function (e, t) {
          if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
          return !t || "object" != typeof t && "function" != typeof t ? e : t
        }(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this));
        return n.moduleRelativeURL = null, n.tableData = [], n.sourceData = [], n.filter = null, n.origFilter = null, n.orderBy = null, n.currentElement = null, n.initAdapter(e, a, i, l), n
      }
      return function (e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
          constructor: {
            value: e,
            enumerable: !1,
            writable: !0,
            configurable: !0
          }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
      }(t, l.default), i(t, [{
        key: "initAdapter",
        value: function (e, t, a, i) {
          this.moduleRelativeURL = baseUrl, this.table = e, this.tab = null == t ? e : t, this.filter = null == a ? null : a, this.origFilter = this.filter, this.orderBy = null == i ? null : i, this.trackEvent("initAdapter", t), this.requestCache = new n.default
        }
      }, {
        key: "setFilter",
        value: function (e) {
          this.filter = e
        }
      }, {
        key: "preSetFilterExternal",
        value: function (e) {
          this.initialFilter = e
        }
      }, {
        key: "setFilterExternal",
        value: function (e) {
          var t = e;
          null == t && (t = this.initialFilter), null != t && (this.setFilter(t), this.filtersAlreadySet = !0, $("#" + this.getTableName() + "_resetFilters").show(), this.currentFilterString = this.getFilterString(t))
        }
      }, {
        key: "getFilter",
        value: function () {
          return this.filter
        }
      }, {
        key: "setOrderBy",
        value: function (e) {
          this.orderBy = e
        }
      }, {
        key: "getOrderBy",
        value: function () {
          return this.orderBy
        }
      }, {
        key: "add",
        value: function (e, t, a, i) {
          var l = this;
          null == a && (a = !0), $(e).attr("a", "add"), $(e).attr("t", this.table), l.showLoader(), this.requestCache.invalidateTable(this.table), $.post(this.moduleRelativeURL, e, function (e) {
            "SUCCESS" === e.status ? l.addSuccessCallBack(t, e.object, a, i, l) : l.addFailCallBack(t, e.object)
          }, "json").always(function () {
            l.hideLoader()
          }), this.trackEvent("add", this.tab, this.table)
        }
      }, {
        key: "addSuccessCallBack",
        value: function (e, t, a, i, l) {
          a && this.get(e), this.initFieldMasterData(), null != i && i.apply(l, [t]), this.trackEvent("addSuccess", this.tab, this.table)
        }
      }, {
        key: "addFailCallBack",
        value: function (e, t) {
          try {
            this.closePlainMessage()
          } catch (e) { }
          this.showMessage("Error saving", t), this.trackEvent("addFailed", this.tab, this.table)
        }
      }, {
        key: "deleteObj",
        value: function (e, t) {
          var a = this;
          a.showLoader(), this.requestCache.invalidateTable(this.table), $.post(this.moduleRelativeURL, {
            t: this.table,
            a: "delete",
            id: e
          }, function (e) {
            "SUCCESS" === e.status ? a.deleteSuccessCallBack(t, e.object) : a.deleteFailCallBack(t, e.object)
          }, "json").always(function () {
            a.hideLoader()
          }), this.trackEvent("delete", this.tab, this.table)
        }
      }, {
        key: "deleteSuccessCallBack",
        value: function (e, t) {
          this.get(e), this.clearDeleteParams()
        }
      }, {
        key: "deleteFailCallBack",
        value: function (e, t) {
          this.clearDeleteParams(), this.showMessage("Error Occurred while Deleting Item", t)
        }
      }, {
        key: "get",
        value: function (e) {
          var t = this;
          if (this.getRemoteTable()) return this.createTableServer(this.getTableName()), $("#" + this.getTableName() + "Form").hide(), void $("#" + this.getTableName()).show();
          var a = JSON.stringify(this.getSourceMapping()),
            i = "";
          null !== this.getFilter() && (i = JSON.stringify(this.getFilter()));
          var l = "";
          null !== this.getOrderBy() && (l = this.getOrderBy()), a = this.fixJSON(a), i = this.fixJSON(i), t.showLoader(), $.post(this.moduleRelativeURL, {
            t: this.table,
            a: "get",
            sm: a,
            ft: i,
            ob: l
          }, function (a) {
            "SUCCESS" === a.status ? t.getSuccessCallBack(e, a.object) : t.getFailCallBack(e, a.object)
          }, "json").always(function () {
            t.hideLoader()
          }), t.initFieldMasterData(), this.trackEvent("get", this.tab, this.table)
        }
      }, {
        key: "getDataUrl",
        value: function (e) {
          var t = JSON.stringify(this.getSourceMapping()),
            a = JSON.stringify(e),
            i = "";
          null !== this.getFilter() && (i = JSON.stringify(this.getFilter()));
          var l = "";
          null !== this.getOrderBy() && (l = this.getOrderBy());
          var n = this.moduleRelativeURL.replace("service.php", "data.php");
          return n = (n = (n = (n = (n = n + "?t=" + this.table) + "&sm=" + this.fixJSON(t)) + "&cl=" + this.fixJSON(a)) + "&ft=" + this.fixJSON(i)) + "&ob=" + l, this.isSubProfileTable() && (n += "&type=sub"), this.remoteTableSkipProfileRestriction() && (n += "&skip=1"), n
        }
      }, {
        key: "isSubProfileTable",
        value: function () {
          return !1
        }
      }, {
        key: "remoteTableSkipProfileRestriction",
        value: function () {
          return !1
        }
      }, {
        key: "preProcessTableData",
        value: function (e) {
          return e
        }
      }, {
        key: "getSuccessCallBack",
        value: function (e, t) {
          for (var a = [], i = this.getDataMapping(), l = 0; l < t.length; l++) {
            for (var n = [], r = 0; r < i.length; r++) n[r] = t[l][i[r]];
            a.push(this.preProcessTableData(n))
          }
          this.sourceData = t, void 0 !== e.callBack && null !== e.callBack && (void 0 !== e.callBackData && null !== e.callBackData || (e.callBackData = []), e.callBackData.push(t), e.callBackData.push(a), this.callFunction(e.callBack, e.callBackData)), this.tableData = a, void 0 !== e.noRender && null !== e.noRender && !0 === e.noRender || (this.createTable(this.getTableName()), $("#" + this.getTableName() + "Form").hide(), $("#" + this.getTableName()).show())
        }
      }, {
        key: "getFailCallBack",
        value: function (e, t) { }
      }, {
        key: "getElement",
        value: function (e, t, a) {
          var i = this,
            l = JSON.stringify(this.getSourceMapping());
          l = this.fixJSON(l), i.showLoader(), $.post(this.moduleRelativeURL, {
            t: this.table,
            a: "getElement",
            id: e,
            sm: l
          }, function (e) {
            "SUCCESS" === e.status ? (a && delete e.object.id, this.currentElement = e.object, i.getElementSuccessCallBack.apply(i, [t, e.object])) : i.getElementFailCallBack.apply(i, [t, e.object])
          }, "json").always(function () {
            i.hideLoader()
          }), this.trackEvent("getElement", this.tab, this.table)
        }
      }, {
        key: "getElementSuccessCallBack",
        value: function (e, t) {
          void 0 !== e.callBack && null !== e.callBack && (void 0 !== e.callBackData && null !== e.callBackData || (e.callBackData = []), e.callBackData.push(t), this.callFunction(e.callBack, e.callBackData, this)), this.currentElement = t, void 0 !== e.noRender && null !== e.noRender && !0 === e.noRender || this.renderForm(t)
        }
      }, {
        key: "getElementFailCallBack",
        value: function (e, t) { }
      }, {
        key: "getTableData",
        value: function () {
          return this.tableData
        }
      }, {
        key: "getTableName",
        value: function () {
          return this.tab
        }
      }, {
        key: "getFieldValues",
        value: function (e, t) {
          var a = this,
            i = "",
            l = "";
          void 0 !== e[3] && null !== e[3] && (i = e[3]), void 0 !== e[4] && null !== e[4] && (l = JSON.stringify(e[4]));
          var n = this.requestCache.getKey(this.moduleRelativeURL, {
            t: e[0],
            key: e[1],
            value: e[2],
            method: i,
            methodParams: l,
            a: "getFieldValues"
          }),
            r = this.requestCache.getData(n);
          null != r && "SUCCESS" === r.status && (t.callBackData.push(r.data), null !== t.callBackSuccess && void 0 !== t.callBackSuccess && t.callBackData.push(t.callBackSuccess), a.callFunction(t.callBack, t.callBackData));
          var o = function e(i) {
            if ("SUCCESS" === i.status) {
              a.requestCache.setData(this.success.key, i);
              var l = t;
              l.callBackData = [t.callBackData[0]], l.callBackData.push(i.data), null !== l.callBackSuccess && void 0 !== l.callBackSuccess && l.callBackData.push(t.callBackSuccess), a.callFunction(l.callBack, l.callBackData)
            } else "Access violation" === i.message && alert("Error : " + e.table + " " + i.message)
          };
          o.key = n, o.table = e[0], $.post(this.moduleRelativeURL, {
            t: e[0],
            key: e[1],
            value: e[2],
            method: i,
            methodParams: l,
            a: "getFieldValues"
          }, o, "json")
        }
      }, {
        key: "setAdminProfile",
        value: function (e) {
          try {
            localStorage.clear()
          } catch (e) { }
          $.post(this.moduleRelativeURL, {
            a: "setAdminEmp",
            empid: e
          }, function () {
            top.location.href = clientUrl
          }, "json")
        }
      }, {
        key: "customAction",
        value: function (e, t, a, i, l) {
          var n = this;
          a = this.fixJSON(a), l ? $.post(this.moduleRelativeURL, {
            t: this.table,
            a: "ca",
            sa: e,
            mod: t,
            req: a
          }, function (e) {
            "SUCCESS" === e.status ? (i.callBackData.push(e.data), n.callFunction(i.callBackSuccess, i.callBackData)) : (i.callBackData.push(e.data), n.callFunction(i.callBackFail, i.callBackData))
          }, "json") : $.getJSON(this.moduleRelativeURL, {
            t: this.table,
            a: "ca",
            sa: e,
            mod: t,
            req: a
          }, function (e) {
            "SUCCESS" === e.status ? (i.callBackData.push(e.data), n.callFunction(i.callBackSuccess, i.callBackData)) : (i.callBackData.push(e.data), n.callFunction(i.callBackFail, i.callBackData))
          })
        }
      }, {
        key: "sendCustomRequest",
        value: function (e, t, a, i) {
          t.a = e, $.post(this.moduleRelativeURL, t, function (e) {
            "SUCCESS" === e.status ? a(e.data) : i(e.data)
          }, "json")
        }
      }, {
        key: "getCustomActionUrl",
        value: function (e, t) {
          t.a = e;
          var a = "";
          for (var i in t) t.hasOwnProperty(i) && ("" !== a && (a += "&"), a += i + "=" + t[i]);
          return this.moduleRelativeURL + "?" + a
        }
      }, {
        key: "getClientDataUrl",
        value: function () {
          return this.moduleRelativeURL.replace("service.php", "") + "data/"
        }
      }, {
        key: "getCustomUrl",
        value: function (e) {
          return this.moduleRelativeURL.replace("service.php", e)
        }
      }]), t
    }();
    a.default = o
  }, {
    "../api-common/RequestCache": 1,
    "./ModuleBase": 5
  }],
  3: [function (e, t, a) {
    "use strict";
    Object.defineProperty(a, "__esModule", {
      value: !0
    });
    var i, l = function () {
      function e(e, t) {
        for (var a = 0; a < t.length; a++) {
          var i = t[a];
          i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
        }
      }
      return function (t, a, i) {
        return a && e(t.prototype, a), i && e(t, i), t
      }
    }(),
      n = e("./AdapterBase"),
      r = (i = n) && i.__esModule ? i : {
        default: i
      };
    var o = function (e) {
      function t(e, a, i, l) {
        ! function (e, t) {
          if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }(this, t);
        var n = function (e, t) {
          if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
          return !t || "object" != typeof t && "function" != typeof t ? e : t
        }(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this, e, a, i, l));
        return n.topLimit = 0, n.bottomLimit = 0, n.conversations = [], n.type = null, n.container = null, n.loadMoreButton = null, n.start = 0, n.pageSize = 6, n.currentPage = 1, n.hasMoreData = !0, n.searchTerm = "", n.searchInput = null, n.timer = null, n.timeoutDelay = 0, n.topLimitUpdated = !1, n
      }
      return function (e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
          constructor: {
            value: e,
            enumerable: !1,
            writable: !0,
            configurable: !0
          }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
      }(t, r.default), l(t, [{
        key: "getDataMapping",
        value: function () {
          return []
        }
      }, {
        key: "getHeaders",
        value: function () {
          return []
        }
      }, {
        key: "getFormFields",
        value: function () {
          return []
        }
      }, {
        key: "addConversation",
        value: function () {

          // var user = this.getUser().id;
          var user = document.getElementById("receipents");
          var to = user.value;
          if (to === "") {
            // console.log("i am h");
            this.showMessage("Receipient required", "You have to select an employee to recieve message");
            return;
            // alert("this");
          }

          var e = this.validateCreateConversation();
          if (!e) return !1;
          e.type = this.type, e.clienttime = (new Date).getTimezoneOffset();

          e.target = to;
          e.sender = this.getCurrentProfile().id;
          var t = JSON.stringify(e),
            a = [];
          return a.callBackData = [], a.callBackSuccess = "addConversationSuccessCallBack", a.callBackFail = "addConversationFailCallBack", this.customAction("addConversation", "modules=conversations", t, a), !0
        }
      }, {
        key: "clearInputs",
        value: function () {
          $("#contentMessage").data("simplemde").value(""), $("#receipents").val(""), $("#attachment").html(this.gt("Attach File")), $("#attachment_remove").hide(), $("#attachment_download").hide()
        }
      }, {
        key: "uploadPostAttachment",
        value: function () {
          var e = this.generateRandom(14);
          showUploadDialog("attachment_" + e, "Upload Attachment", "Conversation", 1, "attachment", "html", "name", "all")
        }
      }, {
        key: "setConversationType",
        value: function (e) {
          this.type = e
        }
      }, {
        key: "addConversationSuccessCallBack",
        value: function () {
          this.clearInputs();
          this.getConversations(this.topLimit, this.pageSize, !0);
          this.showMessage("Message Sent", "Your message has been sent successfully");

        }
      }, {
        key: "addConversationFailCallBack",
        value: function () { }
      }, {
        key: "deleteConversation",
        value: function (e) {
          var t = {
            id: e
          },
            a = JSON.stringify(t),
            i = [];
          i.callBackData = [], i.callBackSuccess = "deleteConversationSuccessCallBack", i.callBackFail = "deleteConversationFailCallBack", this.customAction("deleteConversation", "modules=conversations", a, i)
        }
      }, {
        key: "deleteConversationSuccessCallBack",
        value: function (e) {
          $("#obj_" + e).fadeOut()
        }
      }, {
        key: "deleteConversationFailCallBack",
        value: function () { }
      }, {
        key: "toggleConversationSize",
        value: function (e) {
          $("#obj_" + e).find(".conversation-body").toggleClass("conversation-small"), $("#obj_" + e).find(".conversation-body").hasClass("conversation-small") ? $("#obj_" + e).find(".conversation-expand-label").html(this.gt("Show More")) : $("#obj_" + e).find(".conversation-expand-label").html(this.gt("Show Less"))
        }
      }, {
        key: "getConversations",
        value: function (e, t, a) {
          var i = JSON.stringify({
            start: e,
            limit: t,
            top: a,
            type: this.type,
            sender: this.getCurrentProfile().id
          }),
            l = [a];
          l.callBackData = l, l.callBackSuccess = "getConversationsSuccessCallBack", l.callBackFail = "getConversationsFailCallBack", this.showConversationLoader(), this.customAction("getConversations", "modules=conversations", i, l)
        }
      }, {
        key: "getConversationsSuccessCallBack",
        value: function (e, t) {
          this.hideLoader();
          var a = [];
          !e && t.length > this.pageSize ? (this.hasMoreData = !0, t.pop(), this.loadMoreButton.removeAttr("disabled"), this.loadMoreButton.show()) : e || (this.hasMoreData = !1, this.loadMoreButton.hide()), e || this.scrollToElementBottom(this.container);
          for (var i = 0; i < t.length; i++) a.push(this.preProcessTableData(t[i]));
          this.sourceData = t, this.topLimitUpdated = !1;
          for (var l = 0; l < a.length; l++) this.renderObject(a[l], e), (a[l].timeint < this.bottomLimit || 0 === this.bottomLimit) && (this.bottomLimit = a[l].timeint), (a[l].timeint > this.topLimit || 0 === this.topLimit) && (this.topLimit = a[l].timeint, this.topLimitUpdated = !0);
          this.hideConversationLoader()
        }
      }, {
        key: "getConversationsFailCallBack",
        value: function () {
          this.hideLoader(), this.hideConversationLoader(), null !== this.timer && (clearTimeout(this.timer), this.timer = null)
        }
      }, {
        key: "getObjectHTML",
        value: function (e) {
          // target;
          // $.ajax({
          //   url: "../../../../rokel_hrm/core/get_employeename.php",
          //   type: "post",
          //   contentType: "application/json",
          //   dataType: "json",
          //   data: JSON.stringify({
          //     target_id: e.target,
          //   }),
          //   success: function (data, textStatus, jQxhr) {

          //     //get the response data
          //     var target_respone = data;

          //     //get the notch values
          //     var firstname = target_respone.data['first_name'];
          //     console.log(firstname);
          //     // var target = firstname;


          //   },
          // });


          // function getUserName(firstname){

          // }

          if (this.getCurrentProfile().id == e.target) {
            var target = "Me";
            var employeeName1 = e.senderName;
          } else {
            var employeeName1 = "Me";
            var target = e.targetName;
          }


          var t = this.getCustomTemplate(this.getTemplateName());
          if (t = (t = (t = (t = (t = t.replace(new RegExp("#_id_#", "g"), e.id)).replace(new RegExp("#_message_#", "g"), e.message)).replace(new RegExp("#_employeeName_#", "g"), employeeName1)).replace(new RegExp("#_employeeImage_#", "g"), e.employeeImage)).replace(new RegExp("#_date_#", "g"), e.date).replace(new RegExp("#_currentUser_#", "g"), this.getCurrentProfile().id).replace(new RegExp("#_target_#", "g"), target), "" !== e.attachment && null !== e.attachment && void 0 !== e.attachment) {
            var a = this.getCustomTemplate("attachment.html");
            a = (a = (a = (a = (a = a.replace(new RegExp("#_attachment_#", "g"), e.attachment)).replace(new RegExp("#_icon_#", "g"), this.getIconByFileType(e.file.type))).replace(new RegExp("#_color_#", "g"), this.getColorByFileType(e.file.type))).replace(new RegExp("#_name_#", "g"), e.file.name)).replace(new RegExp("#_size_#", "g"), e.file.size_text), t = t.replace(new RegExp("#_attachment_#", "g"), a)
          } else t = t.replace(new RegExp("#_attachment_#", "g"), "");
          return t

        }
      }, {
        key: "setPageSize",
        value: function (e) {
          this.pageSize = e
        }
      }, {
        key: "addDomEvents",
        value: function (e) { }
      }, {
        key: "getTemplateName",
        value: function () {
          return "chat.html"
        }
      }, {
        key: "renderObject",
        value: function (e, t) {
          var a = this.getObjectDom(e.id),
            i = this.getObjectHTML(e),
            l = $(i);
          null != a ? a.replace(l) : t ? (this.container.prepend(l), $("#obj_" + e.id).css("background-color", "#FFF8DC"), $("#obj_" + e.id).fadeIn("slow"), $("#obj_" + e.id).animate({
            backgroundColor: "#FFF"
          }, "slow")) : (this.container.append(l), $("#obj_" + e.id).fadeIn("slow")), l.find(".conversation-body").prop("scrollHeight") > 290 && l.find(".conversation-expand").show(), 1 === e.actionDelete && l.find(".delete-button").show(), this.addDomEvents(l)
        }
      }, {
        key: "setContainer",
        value: function (e) {
          this.container = e
        }
      }, {
        key: "setLoadMoreButton",
        value: function (e) {
          var t = this;
          this.loadMoreButton = e, this.loadMoreButton.off().on("click", function () {
            t.loadMoreButton.attr("disabled", "disabled"), t.loadMore([])
          })
        }
      }, {
        key: "showLoadError",
        value: function (e) {
          $("#" + this.getTableName() + "_error").html(e), $("#" + this.getTableName() + "_error").show()
        }
      }, {
        key: "hideLoadError",
        value: function () {
          $("#" + this.getTableName() + "_error").hide()
        }
      }, {
        key: "setSearchBox",
        value: function (e) {
          var t = this;
          this.searchInput = e, this.searchInput.off(), this.searchInput.keydown(function (e) {
            var a = $(this).val();
            13 === e.which ? (e.preventDefault(), t.search([])) : 8 !== e.which && 46 !== e.which || 1 !== a.length || "" === t.searchTerm || t.search([])
          })
        }
      }, {
        key: "getObjectDom",
        value: function (e) {
          var t = this.container.find("#obj_" + e);
          return t.length ? t : null
        }
      }, {
        key: "loadMore",
        value: function (e) {
          this.hasMoreData && (this.currentPage++, this.get(e, !0))
        }
      }, {
        key: "get",
        value: function (e, t) {
          var a = this;
          this.hideLoadError(), t || (this.currentPage = 1, null != this.container && this.container.html(""), this.hasMoreData = !0, this.tableData = []), this.start = 1 === this.currentPage ? 0 : this.bottomLimit, this.container = $("#" + this.getTableName()).find(".objectList"), a.showLoader(), this.getConversations(this.start, this.pageSize, !1), null === this.timer && a.getTimeout() > 0 && (this.timeoutDelay = 0, this.timer = setTimeout(function e() {
            a.getConversations(a.topLimit, a.pageSize, !0), a.timeoutDelay += a.getTimeout(), a.topLimitUpdated && (a.timeoutDelay = 0), a.timer = setTimeout(e, a.getTimeout() + a.timeoutDelay)
          }, a.getTimeout() + a.timeoutDelay))
        }
      }, {
        key: "getTimeout",
        value: function () {
          return 0
        }
      }, {
        key: "getTimeoutUpper",
        value: function () {
          return 0
        }
      }, {
        key: "showConversationLoader",
        value: function () { }
      }, {
        key: "hideConversationLoader",
        value: function () { }
      }, {
        key: "search",
        value: function (e) {
          this.searchTerm = $("#" + this.getTableName() + "_search").val(), this.get(e)
        }
      }]), t
    }();
    a.default = o
  }, {
    "./AdapterBase": 2
  }],
  4: [function (e, t, a) {
    "use strict";
    Object.defineProperty(a, "__esModule", {
      value: !0
    });
    var i = function () {
      function e(e, t) {
        for (var a = 0; a < t.length; a++) {
          var i = t[a];
          i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
        }
      }
      return function (t, a, i) {
        return a && e(t.prototype, a), i && e(t, i), t
      }
    }();
    var l = {
      float: function (e) {
        return !(null == e || !e.match(/^[-+]?[0-9]+(\.[0-9]+)?$/))
      },
      number: function (e) {
        return !(null == e || !e.match(/^[0-9]+$/))
      },
      numberOrEmpty: function (e) {
        if ("" === e) return !0;
        return !(null == e || !e.match(/^[0-9]+$/))
      },
      email: function (e) {
        return null != e && /^\s*[\w\-+_]+(\.[\w\-+_]+)*@[\w\-+_]+\.[\w\-+_]+(\.[\w\-+_]+)*\s*$/.test(e)
      },
      emailOrEmpty: function (e) {
        if ("" === e) return !0;
        return null != e && /^\s*[\w\-+_]+(\.[\w\-+_]+)*@[\w\-+_]+\.[\w\-+_]+(\.[\w\-+_]+)*\s*$/.test(e)
      },
      username: function (e) {
        return null != e && /^[a-zA-Z0-9.-]+$/.test(e)
      },
      input: function (e) {
        return null != e && e.length > 0
      }
    },
      n = function () {
        function e(t, a, i) {
          ! function (e, t) {
            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
          }(this, e), this.tempOptions = {}, this.formId = t, this.formError = !1, this.formObject = null, this.errorMessages = "", this.popupDialog = null, this.validateAll = a, this.errorMap = [], this.settings = {
            thirdPartyPopup: null,
            LabelErrorClass: !1,
            ShowPopup: !0
          }, this.settings = jQuery.extend(this.settings, i), this.inputTypes = ["text", "radio", "checkbox", "file", "password", "select-one", "select-multi", "textarea", "fileupload", "signature"], this.validator = l
        }
        return i(e, [{
          key: "clearError",
          value: function (e, t) {
            var a = e.attr("id");
            $("#" + this.formId + " #field_" + a).removeClass("error"), $("#" + this.formId + " #help_" + a).html("")
          }
        }, {
          key: "addError",
          value: function (e, t) {
            this.formError = !0, null != e.attr("message") ? (this.errorMessages += e.attr("message") + "\n", this.errorMap[e.attr("name")] = e.attr("message")) : this.errorMap[e.attr("name")] = "";
            var a = e.attr("id"),
              i = e.attr("validation"),
              l = e.attr("validation");
            $("#" + this.formId + " #field_" + a).addClass("error"), void 0 === l || null == l || "" === l ? $("#" + this.formId + " #help_err_" + a).html(l) : void 0 === i || null == i || "" === i ? $("#" + this.formId + " #help_err_" + a).html("Required") : "float" === i || "number" === i ? $("#" + this.formId + " #help_err_" + a).html("Number required") : "email" === i ? $("#" + this.formId + " #help_err_" + a).html("Email required") : $("#" + this.formId + " #help_err_" + a).html("Required")
          }
        }, {
          key: "showErrors",
          value: function () {
            this.formError && (void 0 !== this.settings.thirdPartyPopup && null != this.settings.thirdPartyPopup ? this.settings.thirdPartyPopup.alert() : !0 === this.settings.ShowPopup && (void 0 !== this.tempOptions.popupTop && null != this.tempOptions.popupTop ? this.alert("Errors Found", this.errorMessages, this.tempOptions.popupTop) : this.alert("Errors Found", this.errorMessages, -1)))
          }
        }, {
          key: "checkValues",
          value: function (e) {
            this.tempOptions = e;
            var t = this;
            this.formError = !1, this.errorMessages = "", this.formObject = {};
            var a = function (e) {
              var a = null,
                i = e.attr("name");
              !1 !== t.settings.LabelErrorClass && $("label[for='" + i + "']").removeClass(t.settings.LabelErrorClass);
              var l = e.attr("id"),
                n = e.attr("type");
              if (e.hasClass("select2-focusser") || e.hasClass("select2-input")) return !0;
              if (jQuery.inArray(n, t.inputTypes) >= 0) {
                if (e.hasClass("uploadInput")) a = e.attr("val");
                else if ("radio" === n || "checkbox" === n) a = $("input[name='" + i + "']:checked").val();
                else if (e.hasClass("select2Field")) a = null != $("#" + t.formId + " #" + l).select2("data") && void 0 !== $("#" + t.formId + " #" + l).select2("data") ? $("#" + t.formId + " #" + l).select2("data").id : "";
                else if (e.hasClass("select2Multi"))
                  if (null != $("#" + t.formId + " #" + l).select2("data") && void 0 !== $("#" + t.formId + " #" + l).select2("data")) {
                    var r = $("#" + t.formId + " #" + l).select2("data");
                    a = [];
                    for (var o = 0; o < r.length; o++) a.push(r[o].id);
                    a = JSON.stringify(a)
                  } else a = "";
                else a = e.hasClass("signatureField") ? $("#" + t.formId + " #" + l).data("signaturePad").isEmpty() ? "" : $("#" + l).data("signaturePad").toDataURL() : e.hasClass("simplemde") ? $("#" + t.formId + " #" + l).data("simplemde").value() : e.hasClass("tinymce") ? tinyMCE.get(l).getContent({
                  format: "raw"
                }) : e.val();
                var s = e.attr("validation"),
                  u = !1;
                void 0 !== s && null != s && void 0 !== t.validator[s] && null != t.validator[s] ? u = t.validator[s](a) : (u = !t.validateAll || (void 0 !== s && null != s && "none" === s || t.validator.input(a)), t.formObject[l] = a), u ? (t.clearError(e, null), t.formObject[l] = a) : t.addError(e, null)
              }
            },
              i = $("#" + this.formId + " :input");
            return i.each(function () {
              a($(this))
            }), (i = $("#" + this.formId + " .uploadInput")).each(function () {
              a($(this))
            }), this.showErrors(), this.tempOptions = {}, !this.formError
          }
        }, {
          key: "getFormParameters",
          value: function () {
            return this.formObject
          }
        }, {
          key: "alert",
          value: function (e) {
            function t(t, a) {
              return e.apply(this, arguments)
            }
            return t.toString = function () {
              return e.toString()
            }, t
          }(function (e, t) {
            alert(t)
          })
        }], [{
          key: "getValidationRules",
          value: function () {
            return l
          }
        }]), e
      }();
    a.default = n
  }, {}],
  5: [function (e, t, a) {
    "use strict";
    Object.defineProperty(a, "__esModule", {
      value: !0
    });
    var i, l = function () {
      function e(e, t) {
        for (var a = 0; a < t.length; a++) {
          var i = t[a];
          i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
        }
      }
      return function (t, a, i) {
        return a && e(t.prototype, a), i && e(t, i), t
      }
    }(),
      n = e("./FormValidation"),
      r = (i = n) && i.__esModule ? i : {
        default: i
      };
    var o = function () {
      function e() {
        ! function (e, t) {
          if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }(this, e), this.deleteParams = {}, this.createRemoteTable = !1, this.instanceId = "None", this.ga = [], this.showEdit = !0, this.showDelete = !0, this.showSave = !0, this.showCancel = !0, this.showFormOnPopup = !1, this.filtersAlreadySet = !1, this.currentFilterString = "", this.sorting = 0, this.settings = {}, this.translations = {}, this.customFields = [], this.csrfRequired = !1, this.fieldTemplates = null, this.templates = null, this.customTemplates = null, this.emailTemplates = null, this.fieldMasterData = null, this.fieldMasterDataKeys = null, this.fieldMasterDataCallback = null, this.sourceMapping = null, this.currentId = null, this.currentElement = null, this.user = null, this.currentProfile = null, this.permissions = {}, this.baseUrl = null
      }
      return l(e, [{
        key: "init",
        value: function (e, t, a, i) { }
      }, {
        key: "setNoJSONRequests",
        value: function (e) {
          this.noJSONRequests = e
        }
      }, {
        key: "setPermissions",
        value: function (e) {
          this.permissions = e
        }
      }, {
        key: "sortingStarted",
        value: function (e) {
          this.sorting = e
        }
      }, {
        key: "checkPermission",
        value: function (e) {
          return void 0 === this.permissions[e] || null == this.permissions[e] || "Yes" === this.permissions[e] ? "Yes" : this.permissions[e]
        }
      }, {
        key: "setBaseUrl",
        value: function (e) {
          this.baseUrl = e
        }
      }, {
        key: "setUser",
        value: function (e) {
          this.user = e
        }
      }, {
        key: "getUser",
        value: function () {
          return this.user
        }
      }, {
        key: "setInstanceId",
        value: function (e) {
          this.instanceId = e
        }
      }, {
        key: "setCSRFRequired",
        value: function (e) {
          this.csrfRequired = e
        }
      }, {
        key: "scrollToTop",
        value: function () {
          $("html, body").animate({
            scrollTop: 0
          }, "fast")
        }
      }, {
        key: "scrollToBottom",
        value: function () {
          $("html, body").animate({
            scrollTop: $(document).height()
          }, "slow")
        }
      }, {
        key: "scrollToElement",
        value: function (e) {
          $(window).height() <= e.offset().top && $("html, body").animate({
            scrollTop: e.offset().top
          }, "slow")
        }
      }, {
        key: "scrollToElementBottom",
        value: function (e) {
          $(window).height() <= e.offset().top + e.height() && $("html, body").animate({
            scrollTop: e.offset().top + e.height()
          }, "slow")
        }
      }, {
        key: "setTranslations",
        value: function (e) {
          this.translations = e.messages[""]
        }
      }, {
        key: "setTranslationsSubModules",
        value: function (e) {
          this.translations = e
        }
      }, {
        key: "gt",
        value: function (e) {
          return void 0 === this.translations[e] || null === this.translations[e] ? e : this.translations[e][0]
        }
      }, {
        key: "addToLangTerms",
        value: function (e) {
          var t = void 0,
            a = localStorage.getItem("terms");
          if (void 0 === a) t = {};
          else try {
            t = JSON.parse(a)
          } catch (e) {
            t = {}
          }
          void 0 === this.translations[e] && (t[e] = e, localStorage.setItem("terms", JSON.stringify(t)))
        }
      }, {
        key: "showActionButtons",
        value: function () {
          return !0
        }
      }, {
        key: "trackEvent",
        value: function (e, t, a) {
          try {
            void 0 === t || null == t ? this.ga.push(["_trackEvent", this.instanceId, e]) : void 0 === a || null == a ? this.ga.push(["_trackEvent", this.instanceId, e, t]) : this.ga.push(["_trackEvent", this.instanceId, e, t, a])
          } catch (e) { }
        }
      }, {
        key: "setCurrentProfile",
        value: function (e) {
          this.currentProfile = e
        }
      }, {
        key: "getCurrentProfile",
        value: function () {
          return this.currentProfile
        }
      }, {
        key: "initFieldMasterData",
        value: function (e, t, a) {
          var i = void 0;
          void 0 !== this.showAddNew && null != this.showAddNew || (this.showAddNew = !0), this.fieldMasterData = {}, this.fieldMasterDataKeys = {}, this.fieldMasterDataCallback = t, this.fieldMasterDataCallbackData = a, this.sourceMapping = {};
          var l = this.getFormFields(),
            n = this.getFilters();
          if (null != n)
            for (var r = 0; r < n.length; r++)(null == (i = this.getMetaFieldValues(n[r][0], l)) || "select" !== i.type && "select2" !== i.type && "select2multi" !== i.type) && l.push(n[r]);
          for (var o = [], s = [], u = null, c = null, d = 0; d < l.length; d++)
            if (void 0 !== (u = l[d])[1]["remote-source"] && null !== u[1]["remote-source"]) {
              var h = u[1]["remote-source"][0] + "_" + u[1]["remote-source"][1] + "_" + u[1]["remote-source"][2];
              o.push(u), s.push(h)
            } else if (void 0 !== u[1].form && null !== u[1].form)
              for (var f = 0; f < u[1].form.length; f++)
                if (void 0 !== (c = u[1].form[f])[1]["remote-source"] && null !== c[1]["remote-source"]) {
                  var p = c[1]["remote-source"][0] + "_" + c[1]["remote-source"][1] + "_" + c[1]["remote-source"][2];
                  s.indexOf(p) < 0 && (o.push(c), s.push(p))
                } for (var v = 0; v < o.length; v++) {
                  var m = o[v];
                  if (void 0 !== m[1]["remote-source"] && null != m[1]["remote-source"]) {
                    var g = m[1]["remote-source"][0] + "_" + m[1]["remote-source"][1] + "_" + m[1]["remote-source"][2];
                    this.fieldMasterDataKeys[g] = !1, this.sourceMapping[m[0]] = m[1]["remote-source"];
                    var y = {
                      callBack: "initFieldMasterDataResponse"
                    };
                    y.callBackData = [g], null != e && (y.callBackSuccess = e), this.getFieldValues(m[1]["remote-source"], y)
                  }
                }
        }
      }, {
        key: "setShowFormOnPopup",
        value: function (e) {
          this.showFormOnPopup = e
        }
      }, {
        key: "setRemoteTable",
        value: function (e) {
          this.createRemoteTable = e
        }
      }, {
        key: "setSettings",
        value: function (e) {
          this.settings = e
        }
      }, {
        key: "getRemoteTable",
        value: function () {
          return this.createRemoteTable
        }
      }, {
        key: "isAllLoaded",
        value: function (e) {
          for (var t in e)
            if (!1 === e[t]) return !1;
          return !0
        }
      }, {
        key: "initFieldMasterDataResponse",
        value: function (e, t, a, i) {
          this.fieldMasterData[e] = t, this.fieldMasterDataKeys[e] = !0, null != a && a(), null !== this.fieldMasterDataCallback && void 0 !== this.fieldMasterDataCallback && this.isAllLoaded(this.fieldMasterDataKeys) && null !== this.fieldMasterDataCallbackData && void 0 !== this.fieldMasterDataCallbackData ? this.fieldMasterDataCallback(this.fieldMasterDataCallbackData) : null !== this.fieldMasterDataCallback && void 0 !== this.fieldMasterDataCallback && this.isAllLoaded(this.fieldMasterDataKeys) && this.fieldMasterDataCallback()
        }
      }, {
        key: "getMetaFieldValues",
        value: function (e, t) {
          for (var a = 0; a < t.length; a++)
            if (e === t[a][0]) return t[a][1];
          return null
        }
      }, {
        key: "getThemeColors",
        value: function () {
          return ["red", "yellow", "aqua", "blue", "light-blue", "green", "navy", "teal", "olive", "orange", "fuchsia", "purple"]
        }
      }, {
        key: "getColorByRandomString",
        value: function (e) {
          var t = this.getThemeColors();
          return t[e.charCodeAt(0) % t.length]
        }
      }, {
        key: "getColorByFileType",
        value: function (e) {
          e = e.toLowerCase();
          var t = {
            pdf: "red",
            csv: "yellow",
            xls: "green",
            xlsx: "green",
            doc: "light-blue",
            docx: "light-blue"
          };
          return t.docx = "blue", t.ppt = "orange", t.pptx = "orange", t.jpg = "teal", t.jpeg = "teal", t.gif = "green", t.png = "yellow", t.bmp = "fuchsia", void 0 !== t[e] || null != t[e] ? t[e] : this.getColorByRandomString(e)
        }
      }, {
        key: "getIconByFileType",
        value: function (e) {
          var t = {
            pdf: "fa fa-file-pdf-o",
            csv: "fa fa fa-file-code-o",
            xls: "fa fa-file-excel-o",
            xlsx: "fa fa-file-excel-o",
            doc: "fa fa-file-word-o",
            docx: "fa fa-file-word-o",
            ppt: "fa fa-file-powerpoint-o",
            pptx: "fa fa-file-powerpoint-o",
            jpg: "fa fa-file-image-o",
            jpeg: "fa fa-file-image-o",
            gif: "fa fa-file-image-o",
            png: "fa fa-file-image-o",
            bmp: "fa fa-file-image-o",
            txt: "fa fa-file-text-o",
            rtf: "fa fa-file-text-o"
          };
          return void 0 !== t[e = e.toLowerCase()] || null != t[e] ? t[e] : "fa fa-file-o"
        }
      }, {
        key: "getSourceMapping",
        value: function () {
          return this.sourceMapping
        }
      }, {
        key: "setTesting",
        value: function (e) {
          this.testing = e
        }
      }, {
        key: "consoleLog",
        value: function (e) {
          this.testing && console.log(e)
        }
      }, {
        key: "setClientMessages",
        value: function (e) {
          this.msgList = e
        }
      }, {
        key: "setTemplates",
        value: function (e) {
          this.templates = e
        }
      }, {
        key: "getWSProperty",
        value: function (e, t) {
          return e.hasOwnProperty(t) ? e[t] : null
        }
      }, {
        key: "getClientMessage",
        value: function (e) {
          return this.getWSProperty(this.msgList, e)
        }
      }, {
        key: "getTemplate",
        value: function (e) {
          return this.getWSProperty(this.templates, e)
        }
      }, {
        key: "setGoogleAnalytics",
        value: function (e) {
          this.gaq = e
        }
      }, {
        key: "showView",
        value: function (e) {
          null != this.currentView && (this.previousView = this.currentView, $("#" + this.currentView).hide()), $("#" + e).show(), this.currentView = e, this.moveToTop()
        }
      }, {
        key: "showPreviousView",
        value: function () {
          this.showView(this.previousView)
        }
      }, {
        key: "moveToTop",
        value: function () { }
      }, {
        key: "callFunction",
        value: function (e, t, a) {
          if ($.isFunction(e)) try {
            null == a ? e.apply(document, t) : e.apply(a, t)
          } catch (e) {
            console.log(e.message)
          } else {
            var i = this[e];
            if ($.isFunction(i)) try {
              i.apply(this, t)
            } catch (e) {
              console.log(e.message)
            }
          }
        }
      }, {
        key: "getTableTopButtonHtml",
        value: function () {
          var e = "";
          return this.getShowAddNew() && (e = '<button onclick="modJs.renderForm();return false;" class="btn btn-small btn-primary">' + this.gt(this.getAddNewLabel()) + ' <i class="fa fa-plus"></i></button>'), null != this.getFilters() && ("" !== e && (e += "&nbsp;&nbsp;"), e += '<button onclick="modJs.showFilters();return false;" class="btn btn-small btn-primary">' + this.gt("Filter") + ' <i class="fa fa-filter"></i></button>', e += "&nbsp;&nbsp;", this.filtersAlreadySet ? e += '<button id="__id___resetFilters" onclick="modJs.resetFilters();return false;" class="btn btn-small btn-default">__filterString__ <i class="fa fa-times"></i></button>' : e += '<button id="__id___resetFilters" onclick="modJs.resetFilters();return false;" class="btn btn-small btn-default" style="display:none;">__filterString__ <i class="fa fa-times"></i></button>'), e = e.replace(/__id__/g, this.getTableName()), "" !== (e = "" !== this.currentFilterString && null != this.currentFilterString ? e.replace(/__filterString__/g, this.currentFilterString) : e.replace(/__filterString__/g, "Reset Filters")) && (e = '<div class="row"><div class="col-xs-12">' + e + "</div></div>"), e
        }
      }, {
        key: "getActionButtonHeader",
        value: function () {
          return {
            sTitle: "",
            sClass: "center"
          }
        }
      }, {
        key: "getTableHTMLTemplate",
        value: function () {
          return '<div class="box-body table-responsive"><table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="grid"></table></div>'
        }
      }, {
        key: "isSortable",
        value: function () {
          return !0
        }
      }, {
        key: "createTable",
        value: function (e) {
          if (this.getRemoteTable()) this.createTableServer(e);
          else {
            var t = this.getHeaders();
            for (var a in t) t[a].sTitle = this.gt(t[a].sTitle);
            var i = this.getTableData();
            if (this.showActionButtons() && t.push(this.getActionButtonHeader()), this.showActionButtons())
              for (var l = 0; l < i.length; l++) i[l].push(this.getActionButtonsHtml(i[l][0], i[l]));
            var n;
            n = this.getTableTopButtonHtml() + this.getTableHTMLTemplate();
            var r = $("#" + e + " .dataTables_paginate .active a").html(),
              o = 0;
            void 0 !== r && null != r && (o = 15 * parseInt(r, 10) - 15), $("#" + e).html(n);
            var s = {
              oLanguage: {
                sLengthMenu: "_MENU_ records per page"
              },
              aaData: i,
              aoColumns: t,
              bSort: this.isSortable(),
              iDisplayLength: 15,
              iDisplayStart: o
            },
              u = this.getCustomTableParams();
            $.extend(s, u), $("#" + e + " #grid").dataTable(s), $(".dataTables_paginate ul").addClass("pagination"), $(".dataTables_length").hide(), $(".dataTables_filter input").addClass("form-control"), $(".dataTables_filter input").attr("placeholder", "Search"), $(".dataTables_filter label").contents().filter(function () {
              return 3 === this.nodeType
            }).remove(), $(".tableActionButton").tooltip()
          }
        }
      }, {
        key: "createTableServer",
        value: function (e) {
          var t = this.getHeaders();
          for (var a in t.push({
            sTitle: "",
            sClass: "center"
          }), t) t[a].sTitle = this.gt(t[a].sTitle);
          var i;
          i = this.getTableTopButtonHtml() + this.getTableHTMLTemplate();
          var l = $("#" + e + " .dataTables_paginate .active a").html(),
            n = 0;
          void 0 !== l && null != l && (n = 15 * parseInt(l, 10) - 15), $("#" + e).html(i);
          var r = {
            oLanguage: {
              sLengthMenu: "_MENU_ records per page"
            },
            bProcessing: !0,
            bServerSide: !0,
            sAjaxSource: this.getDataUrl(this.getDataMapping()),
            aoColumns: t,
            bSort: this.isSortable(),
            parent: this,
            iDisplayLength: 15,
            iDisplayStart: n
          };
          this.showActionButtons() && (r.aoColumnDefs = [{
            fnRender: this.getActionButtons,
            aTargets: [this.getDataMapping().length]
          }]);
          var o = this.getCustomTableParams();
          $.extend(r, o), $("#" + e + " #grid").dataTable(r), $(".dataTables_paginate ul").addClass("pagination"), $(".dataTables_length").hide(), $(".dataTables_filter input").addClass("form-control"), $(".dataTables_filter input").attr("placeholder", "Search"), $(".dataTables_filter label").contents().filter(function () {
            return 3 === this.nodeType
          }).remove(), $(".tableActionButton").tooltip()
        }
      }, {
        key: "getHeaders",
        value: function () { }
      }, {
        key: "getDataMapping",
        value: function () { }
      }, {
        key: "getFormFields",
        value: function () { }
      }, {
        key: "getTableData",
        value: function () { }
      }, {
        key: "getFilters",
        value: function () {
          return null
        }
      }, {
        key: "edit",
        value: function (e) {
          this.currentId = e, this.getElement(e, [])
        }
      }, {
        key: "copyRow",
        value: function (e) {
          this.getElement(e, [], !0)
        }
      }, {
        key: "renderModel",
        value: function (e, t, a) {
          $("#" + e + "ModelBody").html(""), void 0 !== a && null != a || (a = ""), $("#" + e + "ModelLabel").html(t), $("#" + e + "ModelBody").html(a)
        }
      }, {
        key: "renderYesNoModel",
        value: function (e, t, a, i, l, n) {
          var r = this,
            o = "#yesnoModel";
          void 0 !== t && null != t || (t = ""), $(o + "Label").html(e), $(o + "Body").html(t), null != a && $(o + "YesBtn").html(a), null != i && $(o + "NoBtn").html(i), $(o + "YesBtn").off().on("click", function () {
            void 0 !== l && null != l && (l.apply(r, n), r.cancelYesno())
          }), $(o).modal({
            backdrop: "static"
          })
        }
      }, {
        key: "renderModelFromDom",
        value: function (e, t, a) {
          $("#" + e + "ModelBody").html(""), void 0 !== a && null != a || (a = $("<div></div>")), $("#" + e + "ModelLabel").html(t), $("#" + e + "ModelBody").html(""), $("#" + e + "ModelBody").append(a)
        }
      }, {
        key: "deleteRow",
        value: function (e) {
          this.deleteParams.id = e, this.renderModel("delete", "Confirm Deletion", "Are you sure you want to delete this item ?"), $("#deleteModel").modal("show")
        }
      }, {
        key: "showMessage",
        value: function (e, t) {
          var a = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null,
            i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : null,
            l = arguments.length > 4 && void 0 !== arguments[4] && arguments[4],
            n = this,
            r = "";
          r = l ? "#plainMessageModel" : "#messageModel", $(r).off(), l ? this.renderModel("plainMessage", e, t) : this.renderModel("message", e, t), null != a ? ($(r).modal({
            show: !0
          }), $(r).on("hidden.bs.modal", function () {
            a.apply(n, i), $(".modal-backdrop").remove()
          })) : $(r).modal({
            backdrop: "static"
          })
        }
      }, {
        key: "showDomElement",
        value: function (e, t, a, i, l) {
          var n = this,
            r = "";
          r = l ? "#dataMessageModel" : "#messageModel", $(r).unbind("hide"), l ? this.renderModelFromDom("dataMessage", e, t) : this.renderModelFromDom("message", e, t), null != a ? ($(r).modal({
            show: !0
          }), $(r).on("hidden.bs.modal", function () {
            a.apply(n, i), $(".modal-backdrop").remove()
          })) : $(r).modal({
            backdrop: "static"
          })
        }
      }, {
        key: "confirmDelete",
        value: function () {
          void 0 === this.deleteParams.id && null == this.deleteParams.id || this.deleteObj(this.deleteParams.id, []), $("#deleteModel").modal("hide")
        }
      }, {
        key: "cancelDelete",
        value: function () {
          $("#deleteModel").modal("hide"), this.deleteParams.id = null
        }
      }, {
        key: "closeMessage",
        value: function () {
          $("#messageModel").modal("hide")
        }
      }, {
        key: "cancelYesno",
        value: function () {
          $("#yesnoModel").modal("hide")
        }
      }, {
        key: "closePlainMessage",
        value: function () {
          $("#plainMessageModel").modal("hide"), $("#dataMessageModel").modal("hide")
        }
      }, {
        key: "closeDataMessage",
        value: function () {
          $("#dataMessageModel").modal("hide")
        }
      }, {
        key: "save",
        value: function (e, t) {
          var a = new r.default(this.getTableName() + "_submit", !0, {
            ShowPopup: !1,
            LabelErrorClass: "error"
          });
          if (a.checkValues()) {
            var i = a.getFormParameters();
            i = this.forceInjectValuesBeforeSave(i);
            var l = this.doCustomValidation(i);
            if (null == l) {
              this.csrfRequired && (i.csrf = $("#" + this.getTableName() + "Form").data("csrf"));
              var n = $("#" + this.getTableName() + "_submit #id").val();
              null != n && void 0 !== n && "" !== n && (i.id = n), i = this.makeEmptyDateFieldsNull(i), this.add(i, [], e, t)
            } else $("#" + this.getTableName() + "Form .label").html(l), $("#" + this.getTableName() + "Form .label").show(), this.scrollToTop()
          }
        }
      }, {
        key: "makeEmptyDateFieldsNull",
        value: function (e) {
          return this.getFormFields().forEach(function (t) {
            "date" !== t[1].type && "datetime" !== t[1].type || "" !== e[t[0]] && "0000-00-00" !== e[t[0]] && "0000-00-00 00:00:00" !== e[t[0]] || ("none" === t[1].validation ? e[t[0]] = "NULL" : delete e[t[0]])
          }), e
        }
      }, {
        key: "forceInjectValuesBeforeSave",
        value: function (e) {
          return e
        }
      }, {
        key: "doCustomValidation",
        value: function (e) {
          return null
        }
      }, {
        key: "filterQuery",
        value: function () {
          var e = new r.default(this.getTableName() + "_filter", !0, {
            ShowPopup: !1,
            LabelErrorClass: "error"
          });
          if (e.checkValues()) {
            var t = e.getFormParameters();
            if (this.doCustomFilterValidation(t)) {
              for (var a in t) t.hasOwnProperty(a) && "NULL" === t[a] && delete t[a];
              this.setFilter(t), this.filtersAlreadySet = !0, $("#" + this.getTableName() + "_resetFilters").show(), this.currentFilterString = this.getFilterString(t), this.get([]), this.closePlainMessage()
            }
          }
        }
      }, {
        key: "getFilterString",
        value: function (e) {
          var t = "",
            a = void 0,
            i = void 0,
            l = void 0,
            n = void 0,
            r = void 0,
            o = void 0,
            s = this.getFilters();
          for (var u in null == l && (l = []), e)
            if (e.hasOwnProperty(u)) {
              if (r = "", o = null, "select" === (l = this.getMetaFieldValues(u, s)).type || "select2" === l.type) {
                if (void 0 !== l["remote-source"] && null != l["remote-source"]) a = l["remote-source"], "NULL" === e[u] ? r = void 0 !== l["null-label"] && null != l["null-label"] ? l["null-label"] : "Not Selected" : o = r = this.fieldMasterData[a[0] + "_" + a[1] + "_" + a[2]][e[u]];
                else if (i = l.source[0], "NULL" === e[u]) r = void 0 !== l["null-label"] && null != l["null-label"] ? l["null-label"] : "Not Selected";
                else
                  for (var c = 0; c < i.length; c++)
                    if (e[u] === l.source[c][0]) {
                      o = r = l.source[c][1];
                      break
                    }
              } else if ("select2multi" === l.type) {
                n = [];
                try {
                  n = JSON.parse(e[u])
                } catch (e) { }
                "" !== (r = n.join(",")) && (o = r)
              } else "" !== (r = e[u]) && (o = r);
              null != o && ("" !== t && (t += " | "), t += l.label + " = " + r)
            } return t
        }
      }, {
        key: "doCustomFilterValidation",
        value: function (e) {
          return !0
        }
      }, {
        key: "resetFilters",
        value: function () {
          this.filter = this.origFilter, this.filtersAlreadySet = !1, $("#" + this.getTableName() + "_resetFilters").hide(), this.currentFilterString = "", this.get([])
        }
      }, {
        key: "showFilters",
        value: function (e) {
          for (var t = this.templates.filterTemplate, a = "", i = this.getFilters(), l = 0; l < i.length; l++) {
            var n = this.getMetaFieldForRendering(i[l][0]);
            if ("" === n || void 0 === n) a += this.renderFormField(i[l]);
            else {
              var r = e[n];
              "" !== r && null != r && void 0 !== r && "" !== r.trim() ? a += this.renderFormField(JSON.parse(r)) : a += this.renderFormField(i[l])
            }
          }
          t = (t = t.replace(/_id_/g, this.getTableName() + "_filter")).replace(/_fields_/g, a);
          var o = this.generateRandom(14),
            s = $('<div class="reviewBlock popupForm" data-content="Form"></div>');
          s.attr("id", o), s.html(t), s.find(".datefield").datepicker({
            viewMode: 2
          }), s.find(".timefield").datetimepicker({
            language: "en",
            pickDate: !1
          }), s.find(".datetimefield").datetimepicker({
            language: "en"
          }), s.find(".colorpick").colorpicker(), tinymce.init({
            selector: "#" + s.attr("id") + " .tinymce",
            height: "400"
          }), s.find(".simplemde").each(function () {
            var e = new SimpleMDE({
              element: $(this)[0]
            });
            $(this).data("simplemde", e)
          }), s.find(".select2Field").each(function () {
            $(this).select2().select2("val", $(this).find("option:eq(0)").val())
          }), s.find(".select2Multi").each(function () {
            $(this).select2().on("change", function (e) {
              var t = $(this).parents(".row"),
                a = t.find(".select2-choices").height();
              t.height(parseInt(a, 10))
            })
          }), this.showDomElement("Edit", s, null, null, !0), $(".filterBtn").off(), $(".filterBtn").on("click", function (e) {
            e.preventDefault(), e.stopPropagation();
            try {
              modJs.filterQuery()
            } catch (e) { }
            return !1
          }), void 0 !== this.filter && null != this.filter && "" !== this.filter && this.fillForm(this.filter, "#" + this.getTableName() + "_filter", this.getFilters())
        }
      }, {
        key: "preRenderForm",
        value: function (e) { }
      }, {
        key: "renderForm",
        value: function (e) {
          var t = [];
          null != e && void 0 !== e || (this.currentId = null), this.preRenderForm(e);
          for (var a = this.templates.formTemplate, i = "", l = this.getFormFields(), n = 0; n < l.length; n++) {
            var r = this.getMetaFieldForRendering(l[n][0]);
            if ("" === r || void 0 === r) i += this.renderFormField(l[n]);
            else {
              var o = e[r];
              "" !== o && null != o && void 0 !== o && "" !== o.trim() ? i += this.renderFormField(JSON.parse(o)) : i += this.renderFormField(l[n])
            }
          }
          a = (a = a.replace(/_id_/g, this.getTableName() + "_submit")).replace(/_fields_/g, i);
          var s = void 0,
            u = this.generateRandom(14);
          this.showFormOnPopup ? (s = $('<div class="reviewBlock popupForm" data-content="Form"></div>')).attr("id", u) : s = $("#" + this.getTableName() + "Form"), s.html(a), s.find(".datefield").datepicker({
            viewMode: 2
          }), s.find(".timefield").datetimepicker({
            language: "en",
            pickDate: !1
          }), s.find(".datetimefield").datetimepicker({
            language: "en"
          }), s.find(".colorpick").colorpicker(), tinymce.init({
            selector: "#" + s.attr("id") + " .tinymce",
            height: "400"
          }), s.find(".simplemde").each(function () {
            var e = new SimpleMDE({
              element: $(this)[0]
            });
            $(this).data("simplemde", e)
          }), s.find(".select2Field").each(function () {
            $(this).select2().select2("val", $(this).find("option:eq(0)").val())
          }), s.find(".select2Multi").each(function () {
            $(this).select2().on("change", function (e) {
              var t = $(this).parents(".row"),
                a = t.find(".select2-choices").height();
              t.height(parseInt(a, 10))
            })
          }), s.find(".signatureField").each(function () {
            t.push($(this).attr("id"))
          });
          for (var c = 0; c < l.length; c++) "datagroup" === l[c][1].type && s.find("#" + l[c][0]).data("field", l[c]);
          if (!1 === this.showSave ? s.find(".saveBtn").remove() : (s.find(".saveBtn").off(), s.find(".saveBtn").data("modJs", this), s.find(".saveBtn").on("click", function () {
            return null != $(this).data("modJs").saveSuccessItemCallback && void 0 !== $(this).data("modJs").saveSuccessItemCallback ? $(this).data("modJs").save($(this).data("modJs").retriveItemsAfterSave(), $(this).data("modJs").saveSuccessItemCallback) : $(this).data("modJs").save(), !1
          })), !1 === this.showCancel ? s.find(".cancelBtn").remove() : (s.find(".cancelBtn").off(), s.find(".cancelBtn").data("modJs", this), s.find(".cancelBtn").on("click", function () {
            return $(this).data("modJs").cancel(), !1
          })), s.find("[mask]").each(function () {
            $(this).inputmask($(this).attr("mask"))
          }), s.find("[datemask]").each(function () {
            $(this).inputmask({
              mask: "y-1-2",
              placeholder: "YYYY-MM-DD",
              leapday: "-02-29",
              separator: "-",
              alias: "yyyy/mm/dd"
            })
          }), s.find("[datetimemask]").each(function () {
            $(this).inputmask("datetime", {
              mask: "y-2-1 h:s:00",
              placeholder: "YYYY-MM-DD hh:mm:ss",
              leapday: "-02-29",
              separator: "-",
              alias: "yyyy/mm/dd"
            })
          }), this.showFormOnPopup) {
            this.showMessage("Edit", "", null, null, !0), $("#plainMessageModel .modal-body").html(""), $("#plainMessageModel .modal-body").append(s);
            for (var d = 0; d < t.length; d++) $("#" + t[d]).data("signaturePad", new SignaturePad(document.getElementById(t[d])));
            void 0 !== e && null != e ? this.fillForm(e, "#" + u) : this.setDefaultValues("#" + u)
          } else {
            $("#" + this.getTableName() + "Form").show(), $("#" + this.getTableName()).hide();
            for (var h = 0; h < t.length; h++) $("#" + t[h]).data("signaturePad", new SignaturePad(document.getElementById(t[h])));
            void 0 !== e && null != e ? this.fillForm(e) : this.setDefaultValues(), this.scrollToTop()
          }
          this.postRenderForm(e, s)
        }
      }, {
        key: "setDefaultValues",
        value: function (e, t) {
          null != t && void 0 !== t || (t = this.getFormFields()), null != e && void 0 !== e && "" !== e || (e = "#" + this.getTableName() + "Form");
          for (var a = 0; a < t.length; a++) "text" !== t[a][1].type && "textarea" !== t[a][1].type || void 0 !== t[a][1].default && null !== t[a][1].default && $(e + " #" + t[a][0]).val(t[a][1].default)
        }
      }, {
        key: "retriveItemsAfterSave",
        value: function () {
          return !0
        }
      }, {
        key: "postRenderForm",
        value: function (e, t) { }
      }, {
        key: "dataGroupToHtml",
        value: function (e, t) {
          var a = JSON.parse(e),
            i = void 0,
            l = void 0,
            n = void 0,
            r = void 0,
            o = t[1].html;
          null != a && void 0 !== a && void 0 !== t[1]["sort-function"] && null != t[1]["sort-function"] && a.sort(t[1]["sort-function"]);
          for (var s = $('<div id="' + t[0] + '_div_inner"></div>'), u = 0; u < a.length; u++) {
            for (var c in l = a[u], void 0 !== t[1]["pre-format-function"] && null != t[1]["pre-format-function"] && (l = t[1]["pre-format-function"].apply(this, [l])), i = (i = (i = (i = o).replace("#_delete_#", '<a id="#_id_#_delete" onclick="modJs.deleteDataGroupItem(\'#_id_#\');return false;" type="button" style="float:right;margin-right:3px;" tooltip="Delete"><li class="fa fa-times"></li></a>')).replace("#_edit_#", '<a id="#_id_#_edit" onclick="modJs.editDataGroupItem(\'#_id_#\');return false;" type="button" style="float:right;margin-right:5px;" tooltip="Edit"><li class="fa fa-edit"></li></a>')).replace(/#_id_#/g, l.id), l) void 0 !== (r = l[c]) && null != r && "string" == typeof r && (r = r.replace(/(?:\r\n|\r|\n)/g, "<br />")), i = i.replace("#_" + c + "_#", r);
            void 0 !== t[1].render && null != t[1].render && (i = i.replace("#_renderFunction_#", t[1].render(l))), (n = $(i)).attr("fieldId", t[0] + "_div"), s.append(n)
          }
          return s
        }
      }, {
        key: "resetDataGroup",
        value: function (e) {
          $("#" + e[0]).val(""), $("#" + e[0] + "_div").html("")
        }
      }, {
        key: "showDataGroup",
        value: function (e, t) {
          var a = this.templates.datagroupTemplate,
            i = "",
            l = e[1].form;
          void 0 !== t && null != t && void 0 !== t.id ? this.currentDataGroupItemId = t.id : this.currentDataGroupItemId = null;
          for (var n = 0; n < l.length; n++) i += this.renderFormField(l[n]);
          a = (a = a.replace(/_id_/g, this.getTableName() + "_field_" + e[0])).replace(/_fields_/g, i);
          var r = this.generateRandom(14),
            o = $('<div class="reviewBlock popupForm" data-content="Form"></div>');
          o.attr("id", r), o.html(a), o.find(".datefield").datepicker({
            viewMode: 2
          }), o.find(".timefield").datetimepicker({
            language: "en",
            pickDate: !1
          }), o.find(".datetimefield").datetimepicker({
            language: "en"
          }), o.find(".colorpick").colorpicker(), tinymce.init({
            selector: "#" + o.attr("id") + " .tinymce",
            height: "400"
          }), o.find(".simplemde").each(function () {
            var e = new SimpleMDE({
              element: $(this)[0]
            });
            $(this).data("simplemde", e)
          }), o.find(".select2Field").each(function () {
            $(this).select2().select2("val", $(this).find("option:eq(0)").val())
          }), o.find(".select2Multi").each(function () {
            $(this).select2().on("change", function (e) {
              var t = $(this).parents(".row"),
                a = t.find(".select2-choices").height();
              t.height(parseInt(a, 10))
            })
          }), this.currentDataGroupField = e, this.showDomElement("Add " + e[1].label, o, null, null, !0), void 0 !== t && null != t ? this.fillForm(t, "#" + this.getTableName() + "_field_" + e[0], e[1].form) : this.setDefaultValues("#" + this.getTableName() + "_field_" + e[0], e[1].form), $(".groupAddBtn").off(), void 0 !== t && null != t && void 0 !== t.id ? $(".groupAddBtn").on("click", function (e) {
            e.preventDefault(), e.stopPropagation();
            try {
              modJs.editDataGroup()
            } catch (e) {
              console.log("Error editing data group: " + e.message)
            }
            return !1
          }) : $(".groupAddBtn").on("click", function (e) {
            e.preventDefault(), e.stopPropagation();
            try {
              modJs.addDataGroup()
            } catch (e) {
              console.log("Error adding data group: " + e.message)
            }
            return !1
          })
        }
      }, {
        key: "addDataGroup",
        value: function () {
          var e = this.currentDataGroupField,
            t = void 0;
          $("#" + this.getTableName() + "_field_" + e[0] + "_error").html(""), $("#" + this.getTableName() + "_field_" + e[0] + "_error").hide();
          var a = new r.default(this.getTableName() + "_field_" + e[0], !0, {
            ShowPopup: !1,
            LabelErrorClass: "error"
          });
          if (a.checkValues()) {
            var i = a.getFormParameters();
            if (void 0 !== e[1]["custom-validate-function"] && null != e[1]["custom-validate-function"]) {
              if (!(t = e[1]["custom-validate-function"].apply(this, [i])).valid) return $("#" + this.getTableName() + "_field_" + e[0] + "_error").html(t.message), $("#" + this.getTableName() + "_field_" + e[0] + "_error").show(), !1;
              i = t.params
            }
            var l = $("#" + e[0]).val();
            "" === l && (l = "[]");
            var n = JSON.parse(l);
            i.id = e[0] + "_" + this.dataGroupGetNextAutoIncrementId(n), n.push(i), void 0 !== e[1]["sort-function"] && null != e[1]["sort-function"] && n.sort(e[1]["sort-function"]), l = JSON.stringify(n);
            var o = this.dataGroupToHtml(l, e);
            $("#" + e[0] + "_div").html(""), $("#" + e[0] + "_div").append(o), this.makeDataGroupSortable(e, $("#" + e[0] + "_div_inner")), $("#" + e[0]).val(l), this.orderDataGroup(e), this.closeDataMessage(), this.showMessage("Item Added", "This change will be effective only when you save the form")
          }
          return !0
        }
      }, {
        key: "nl2br",
        value: function (e, t) {
          var a = "";
          try {
            for (var i = e.split(" "), l = 0, n = 0; n < i.length; n++)(l += i[n].length + 1) > t ? (a += i[n] + "<br/>", l = 0) : a += i[n] + " "
          } catch (e) { }
          return a
        }
      }, {
        key: "makeDataGroupSortable",
        value: function (e, t) {
          t.data("field", e), t.data("firstSort", !0), t.sortable({
            create: function () {
              $(this).height($(this).height())
            },
            "ui-floating": !1,
            start: function (e, t) {
              $("#sortable-ul-selector-id").sortable({
                sort: function (e, t) {
                  var a = $(e.target);
                  if (!/html|body/i.test(a.offsetParent()[0].tagName)) {
                    var i = e.pageY - a.offsetParent().offset().top - t.helper.outerHeight(!0) / 2;
                    t.helper.css({
                      top: i + "px"
                    })
                  }
                }
              })
            },
            revert: !0,
            stop: function () {
              modJs.orderDataGroup($(this).data("field"))
            },
            axis: "y",
            scroll: !1,
            placeholder: "sortable-placeholder",
            cursor: "move"
          })
        }
      }, {
        key: "orderDataGroup",
        value: function (e) {
          var t = [],
            a = void 0,
            i = $("#" + e[0] + "_div_inner [fieldid='" + e[0] + "_div']"),
            l = $("#" + e[0]).val();
          "" === l && (l = "[]");
          var n = JSON.parse(l);
          i.each(function () {
            for (var e in a = $(this).attr("id"), n)
              if (n[e].id === a) {
                t.push(n[e]);
                break
              }
          }), $("#" + e[0]).val(JSON.stringify(t))
        }
      }, {
        key: "editDataGroup",
        value: function () {
          var e = this.currentDataGroupField,
            t = this.currentDataGroupItemId,
            a = new r.default(this.getTableName() + "_field_" + e[0], !0, {
              ShowPopup: !1,
              LabelErrorClass: "error"
            });
          if (a.checkValues()) {
            var i = a.getFormParameters();
            if (void 0 !== e[1]["custom-validate-function"] && null != e[1]["custom-validate-function"]) {
              var l = e[1]["custom-validate-function"].apply(this, [i]);
              if (!l.valid) return $("#" + this.getTableName() + "_field_" + e[0] + "_error").html(l.message), $("#" + this.getTableName() + "_field_" + e[0] + "_error").show(), !1;
              i = l.params
            }
            if (this.doCustomFilterValidation(i)) {
              var n = $("#" + e[0]).val();
              "" === n && (n = "[]");
              for (var o = JSON.parse(n), s = {}, u = -1, c = [], d = 0; d < o.length; d++) {
                var h = o[d];
                h.id === t && (s = h, u = d), c.push(h)
              }
              i.id = s.id, c[u] = i, void 0 !== e[1]["sort-function"] && null != e[1]["sort-function"] && c.sort(e[1]["sort-function"]), n = JSON.stringify(c), $("#" + e[0]).val(n);
              var f = this.dataGroupToHtml(n, e);
              this.orderDataGroup(e), $("#" + e[0] + "_div").html(""), $("#" + e[0] + "_div").append(f), this.makeDataGroupSortable(e, $("#" + e[0] + "_div_inner")), this.closeDataMessage(), this.showMessage("Item Edited", "This change will be effective only when you save the form")
            }
          }
          return !0
        }
      }, {
        key: "editDataGroupItem",
        value: function (e) {
          for (var t = e.substring(0, e.lastIndexOf("_")), a = $("#" + t).val(), i = JSON.parse(a), l = {}, n = 0; n < i.length; n++) {
            var r = i[n];
            r.id === e && (l = r)
          }
          this.showDataGroup($("#" + t).data("field"), l)
        }
      }, {
        key: "dataGroupGetNextAutoIncrementId",
        value: function (e) {
          for (var t = 1, a = void 0, i = 0; i < e.length; i++) {
            var l = e[i];
            void 0 !== l.id && null != l.id || (l.id = 1), (a = l.id.substring(l.id.lastIndexOf("_") + 1, l.id.length)) >= t && (t = parseInt(a, 10) + 1)
          }
          return t
        }
      }, {
        key: "deleteDataGroupItem",
        value: function (e) {
          for (var t = e.substring(0, e.lastIndexOf("_")), a = $("#" + t).val(), i = JSON.parse(a), l = [], n = 0; n < i.length; n++) {
            var r = i[n];
            r.id !== e && l.push(r)
          }
          $("#" + t).val(JSON.stringify(l)), $("#" + e).remove(), this.showMessage("Item Removed", "Item removed. This change will be effective only when you save the form")
        }
      }, {
        key: "fillForm",
        value: function (e, t, a) {
          var i = void 0;
          null != a && void 0 !== a || (a = this.getFormFields()), null != t && void 0 !== t && "" !== t || (t = "#" + this.getTableName() + "Form");
          for (var l = 0; l < a.length; l++)
            if ("date" === a[l][1].type) "0000-00-00" !== e[a[l][0]] && "" !== e[a[l][0]] && null != e[a[l][0]] && void 0 !== e[a[l][0]] && $(t + " #" + a[l][0] + "_date").datepicker("setValue", e[a[l][0]]);
            else if ("colorpick" === a[l][1].type) null != e[a[l][0]] && void 0 !== e[a[l][0]] && ($(t + " #" + a[l][0] + "_colorpick").colorpicker("setValue", e[a[l][0]]), $(t + " #" + a[l][0]).val(e[a[l][0]]));
            else if ("datetime" === a[l][1].type || "time" === a[l][1].type) {
              if ("0000-00-00 00:00:00" !== e[a[l][0]] && "" !== e[a[l][0]] && null != e[a[l][0]] && void 0 !== e[a[l][0]]) {
                var n = e[a[l][0]].split(" "),
                  r = n[0].split("-"),
                  o = n[1].split(":");
                $(t + " #" + a[l][0] + "_datetime").data("datetimepicker").setLocalDate(new Date(r[0], parseInt(r[1], 10) - 1, r[2], o[0], o[1], o[2]))
              }
            } else if ("label" === a[l][1].type) $(t + " #" + a[l][0]).html(e[a[l][0]]);
            else if ("placeholder" === a[l][1].type) {
              if (void 0 !== a[l][1]["remote-source"] && null != a[l][1]["remote-source"]) {
                var s = a[l][1]["remote-source"][0] + "_" + a[l][1]["remote-source"][1] + "_" + a[l][1]["remote-source"][2];
                i = this.fieldMasterData[s][e[a[l][0]]]
              } else i = e[a[l][0]];
              if (void 0 === i || null == i) i = "";
              else try {
                i = i.replace(/(?:\r\n|\r|\n)/g, "<br />")
              } catch (e) { }
              if (void 0 !== a[l][1].formatter && a[l][1].formatter && $.isFunction(a[l][1].formatter)) try {
                i = a[l][1].formatter(i)
              } catch (e) { }
              $(t + " #" + a[l][0]).html(i)
            } else if ("fileupload" === a[l][1].type) null != e[a[l][0]] && void 0 !== e[a[l][0]] && "" !== e[a[l][0]] && ($(t + " #" + a[l][0]).html(e[a[l][0]]), $(t + " #" + a[l][0]).attr("val", e[a[l][0]]), $(t + " #" + a[l][0]).show(), $(t + " #" + a[l][0] + "_download").show(), $(t + " #" + a[l][0] + "_remove").show()), !0 === a[l][1].readonly && $(t + " #" + a[l][0] + "_upload").remove();
            else if ("select" === a[l][1].type) void 0 !== e[a[l][0]] && null != e[a[l][0]] && "" !== e[a[l][0]] || (e[a[l][0]] = "NULL"), $(t + " #" + a[l][0]).val(e[a[l][0]]);
            else if ("select2" === a[l][1].type) void 0 !== e[a[l][0]] && null != e[a[l][0]] && "" !== e[a[l][0]] || (e[a[l][0]] = "NULL"), $(t + " #" + a[l][0]).select2("val", e[a[l][0]]);
            else if ("select2multi" === a[l][1].type) {
              void 0 !== e[a[l][0]] && null != e[a[l][0]] && "" !== e[a[l][0]] || (e[a[l][0]] = "NULL");
              var u = [];
              if (void 0 !== e[a[l][0]] && null != e[a[l][0]] && "" !== e[a[l][0]]) try {
                u = JSON.parse(e[a[l][0]])
              } catch (e) { }
              $(t + " #" + a[l][0]).select2("val", u);
              var c = $(t + " #" + a[l][0]).find(".select2-choices").height();
              $(t + " #" + a[l][0]).find(".controls").css("min-height", c + "px"), $(t + " #" + a[l][0]).css("min-height", c + "px")
            } else if ("datagroup" === a[l][1].type) try {
              var d = this.dataGroupToHtml(e[a[l][0]], a[l]);
              $(t + " #" + a[l][0]).val(e[a[l][0]]), $(t + " #" + a[l][0] + "_div").html(""), $(t + " #" + a[l][0] + "_div").append(d), this.makeDataGroupSortable(a[l], $(t + " #" + a[l][0] + "_div_inner"))
            } catch (e) { } else "signature" === a[l][1].type ? "" === e[a[l][0]] && void 0 === e[a[l][0]] && null == e[a[l][0]] || $(t + " #" + a[l][0]).data("signaturePad").fromDataURL(e[a[l][0]]) : "simplemde" === a[l][1].type ? $(t + " #" + a[l][0]).data("simplemde").value(e[a[l][0]]) : $(t + " #" + a[l][0]).val(e[a[l][0]])
        }
      }, {
        key: "cancel",
        value: function () {
          $("#" + this.getTableName() + "Form").hide(), $("#" + this.getTableName()).show()
        }
      }, {
        key: "renderFormField",
        value: function (e) {
          var t = 0;
          if (void 0 === this.fieldTemplates[e[1].type] || null == this.fieldTemplates[e[1].type]) return "";
          var a = this.fieldTemplates[e[1].type];
          if (e[1].label = this.gt(e[1].label), "none" !== e[1].validation && "emailOrEmpty" !== e[1].validation && "numberOrEmpty" !== e[1].validation && "placeholder" !== e[1].type && e[1].label.indexOf("*") < 0) {
            ["select", "select2"].indexOf(e[1].type) >= 0 && !0 === e[1]["allow-null"] || (e[1].label = e[1].label + '<font class="redFont">*</font>')
          }
          if ("text" === e[1].type || "textarea" === e[1].type || "hidden" === e[1].type || "label" === e[1].type || "placeholder" === e[1].type) a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
          else if ("select" === e[1].type || "select2" === e[1].type || "select2multi" === e[1].type) {
            if (a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label), void 0 !== e[1].source && null != e[1].source) a = a.replace("_options_", this.renderFormSelectOptions(e[1].source, e));
            else if (void 0 !== e[1]["remote-source"] && null != e[1]["remote-source"]) {
              var i = e[1]["remote-source"][0] + "_" + e[1]["remote-source"][1] + "_" + e[1]["remote-source"][2];
              a = a.replace("_options_", this.renderFormSelectOptionsRemote(this.fieldMasterData[i], e))
            }
          } else if ("colorpick" === e[1].type) a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
          else if ("date" === e[1].type) a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
          else if ("datetime" === e[1].type) a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
          else if ("time" === e[1].type) a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
          else if ("fileupload" === e[1].type) {
            a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
            var l = this.getCurrentProfile();
            t = null != l && void 0 !== l ? l.id : -1 * this.getUser().id, a = (a = a.replace(/_userId_/g, t)).replace(/_group_/g, this.tab), a = (a = void 0 !== e[1].filetypes && null != e[1].filetypes ? a.replace(/_filetypes_/g, e[1].filetypes) : a.replace(/_filetypes_/g, "all")).replace(/_rand_/g, this.generateRandom(14))
          } else "datagroup" === e[1].type ? a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label) : "signature" === e[1].type ? a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label) : "tinymce" !== e[1].type && "simplemde" !== e[1].type || (a = (a = a.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label));
          return a = void 0 !== e[1].validation && null != e[1].validation && "" !== e[1].validation ? a.replace(/_validation_/g, 'validation="' + e[1].validation + '"') : a.replace(/_validation_/g, ""), a = void 0 !== e[1].help && null !== e[1].help ? (a = a.replace(/_helpline_/g, e[1].help)).replace(/_hidden_class_help_/g, "") : (a = a.replace(/_helpline_/g, "")).replace(/_hidden_class_help_/g, "hide"), a = void 0 !== e[1].placeholder && null !== e[1].placeholder ? a.replace(/_placeholder_/g, 'placeholder="' + e[1].placeholder + '"') : a.replace(/_placeholder_/g, ""), a = void 0 !== e[1].mask && null !== e[1].mask ? a.replace(/_mask_/g, 'mask="' + e[1].mask + '"') : a.replace(/_mask_/g, "")
        }
      }, {
        key: "renderFormSelectOptions",
        value: function (e, t) {
          var a = "";
          null != t && void 0 !== t && !0 === t[1]["allow-null"] && (void 0 !== t[1]["null-label"] && null != t[1]["null-label"] ? a += '<option value="NULL">' + this.gt(t[1]["null-label"]) + "</option>" : a += '<option value="NULL">Select</option>');
          var i = [];
          for (var l in e) i.push(e[l]);
          !0 === t[1].sort && i.sort(function (e, t) {
            return (e = e[1]) < (t = t[1]) ? -1 : e > t ? 1 : 0
          });
          for (var n = 0; n < i.length; n++) {
            var r = i[n][0],
              o = i[n][1],
              s = '<option value="_id_">_val_</option>';
            a += s = (s = s.replace("_id_", r)).replace("_val_", this.gt(o))
          }
          return a
        }
      }, {
        key: "renderFormSelectOptionsRemote",
        value: function (e, t) {
          var a = "";
          !0 === t[1]["allow-null"] && (void 0 !== t[1]["null-label"] && null != t[1]["null-label"] ? a += '<option value="NULL">' + this.gt(t[1]["null-label"]) + "</option>" : a += '<option value="NULL">Select</option>');
          var i = [];
          for (var l in e) i.push([l, e[l]]);
          "true" === t[1].sort && i.sort(function (e, t) {
            return (e = e[1]) < (t = t[1]) ? -1 : e > t ? 1 : 0
          });
          for (var n = 0; n < i.length; n++) {
            var r = i[n][0],
              o = i[n][1],
              s = '<option value="_id_">_val_</option>';
            a += s = (s = s.replace("_id_", r)).replace("_val_", this.gt(o))
          }
          return a
        }
      }, {
        key: "setCustomTemplates",
        value: function (e) {
          this.customTemplates = e
        }
      }, {
        key: "setEmailTemplates",
        value: function (e) {
          this.emailTemplates = e
        }
      }, {
        key: "getCustomTemplate",
        value: function (e) {
          return this.customTemplates[e]
        }
      }, {
        key: "setFieldTemplates",
        value: function (e) {
          this.fieldTemplates = e
        }
      }, {
        key: "getMetaFieldForRendering",
        value: function (e) {
          return ""
        }
      }, {
        key: "clearDeleteParams",
        value: function () {
          this.deleteParams = {}
        }
      }, {
        key: "getShowAddNew",
        value: function () {
          return this.showAddNew
        }
      }, {
        key: "getAddNewLabel",
        value: function () {
          return "Add New"
        }
      }, {
        key: "setShowAddNew",
        value: function (e) {
          this.showAddNew = e
        }
      }, {
        key: "setShowDelete",
        value: function (e) {
          this.showDelete = e
        }
      }, {
        key: "setShowEdit",
        value: function (e) {
          this.showEdit = e
        }
      }, {
        key: "setShowSave",
        value: function (e) {
          this.showSave = e
        }
      }, {
        key: "setShowCancel",
        value: function (e) {
          this.showCancel = e
        }
      }, {
        key: "getCustomTableParams",
        value: function () {
          return {}
        }
      }, {
        key: "getActionButtons",
        value: function (e) {
          return modJs.getActionButtonsHtml(e.aData[0], e.aData)
        }
      }, {
        key: "getActionButtonsHtml",
        value: function (e, t) {
          var a = '<div style="width:80px;">_edit__delete__clone_</div>';
          return a = this.showAddNew ? a.replace("_clone_", '<img class="tableActionButton" src="_BASE_images/clone.png" style="margin-left:15px;cursor:pointer;" rel="tooltip" title="Copy" onclick="modJs.copyRow(_id_);return false;"></img>') : a.replace("_clone_", ""), a = this.showDelete ? a.replace("_delete_", '<img class="tableActionButton" src="_BASE_images/delete.png" style="margin-left:15px;cursor:pointer;" rel="tooltip" title="Delete" onclick="modJs.deleteRow(_id_);return false;"></img>') : a.replace("_delete_", ""), a = (a = (a = this.showEdit ? a.replace("_edit_", '<img class="tableActionButton" src="_BASE_images/edit.png" style="cursor:pointer;" rel="tooltip" title="Edit" onclick="modJs.edit(_id_);return false;"></img>') : a.replace("_edit_", "")).replace(/_id_/g, e)).replace(/_BASE_/g, this.baseUrl)
        }
      }, {
        key: "generateRandom",
        value: function (e) {
          for (var t = new Date, a = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", i = "", l = e; l > 0; --l) i += a[Math.round(Math.random() * (a.length - 1))];
          return i + t.getTime()
        }
      }, {
        key: "checkFileType",
        value: function (e, t) {
          var a = document.getElementById(e),
            i = "";
          return a.value.lastIndexOf(".") > 0 && (i = a.value.substring(a.value.lastIndexOf(".") + 1, a.value.length)), i = i.toLowerCase(), !(t.split(",").indexOf(i) < 0) || (a.value = "", this.showMessage("File Type Error", "Selected file type is not supported"), this.clearFileElement(e), !1)
        }
      }, {
        key: "clearFileElement",
        value: function (e) {
          var t = $("#" + e);
          t.replaceWith(t = t.val("").clone(!0))
        }
      }, {
        key: "fixJSON",
        value: function (e) {
          return "1" === this.noJSONRequests && (e = window.btoa(e)), e
        }
      }, {
        key: "getClientDate",
        value: function (e) {
          var t = this.getClientGMTOffset();
          return e.addMinutes(60 * t)
        }
      }, {
        key: "getClientGMTOffset",
        value: function () {
          var e = new Date,
            t = new Date(e.getFullYear(), 0, 1, 0, 0, 0, 0),
            a = t.toGMTString();
          return (t - new Date(a.substring(0, a.lastIndexOf(" ") - 1))) / 36e5
        }
      }, {
        key: "getHelpLink",
        value: function () {
          return null
        }
      }, {
        key: "showLoader",
        value: function () {
          $("#iceloader").show()
        }
      }, {
        key: "hideLoader",
        value: function () {
          $("#iceloader").hide()
        }
      }, {
        key: "generateOptions",
        value: function (e) {
          var t = "";
          for (var a in e) t += '<option value="__val__">__text__</option>'.replace("__val__", a).replace("__text__", e[a]);
          return t
        }
      }, {
        key: "isModuleInstalled",
        value: function (e, t) {
          return void 0 !== modulesInstalled && null !== modulesInstalled && 1 === modulesInstalled[e + "_" + t]
        }
      }, {
        key: "setCustomFields",
        value: function (e) {
          for (var t = void 0, a = void 0, i = 0; i < e.length; i++)
            if ("Hidden" !== (t = e[i]).display && "" !== t.data && void 0 !== t.data) try {
              if (void 0 === (a = JSON.parse(t.data)) || null == a) continue;
              if (2 !== a.length) continue;
              if (void 0 === a[1].type || null == a[1].type) continue;
              this.customFields.push(a)
            } catch (e) { }
        }
      }, {
        key: "addCustomFields",
        value: function (e) {
          for (var t = 0; t < this.customFields.length; t++) e.push(this.customFields[t]);
          return e
        }
      }]), e
    }();
    a.default = o
  }, {
    "./FormValidation": 4
  }],
  6: [function (e, t, a) {
    "use strict";
    var i = e("./lib");
    window.ChatAdapter = i.ChatAdapter
  }, {
    "./lib": 7
  }],
  7: [function (e, t, a) {
    "use strict";
    var i, l = function () {
      function e(e, t) {
        for (var a = 0; a < t.length; a++) {
          var i = t[a];
          i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i)
        }
      }
      return function (t, a, i) {
        return a && e(t.prototype, a), i && e(t, i), t
      }
    }(),
      n = e("../../../api/ConversationsAdapter"),
      r = (i = n) && i.__esModule ? i : {
        default: i
      };
    var o = function (e) {
      function t() {
        return function (e, t) {
          if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
        }(this, t),
          function (e, t) {
            if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            return !t || "object" != typeof t && "function" != typeof t ? e : t
          }(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments))
      }
      return function (e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
          constructor: {
            value: e,
            enumerable: !1,
            writable: !0,
            configurable: !0
          }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
      }(t, r.default), l(t, [{
        key: "validateCreateConversation",
        value: function () {
          var e = $("#contentMessage").val(),
            t = $("#attachment").html();
          if ("" === e) return !1;
          var a = {
            message: e
          };
          return "" !== t && this.gt("Attach File") !== t && t && (a.attachment = t), a
        }
      }, {
        key: "clearInputs",
        value: function () {
          $("#contentMessage").val(""), $("#receipents").val(""), $("#attachment").html(this.gt("Attach File")), $("#attachment_remove").hide(), $("#attachment_download").hide()
        }
      }, {
        key: "getTimeout",
        value: function () {
          return 1e4
        }
      }, {
        key: "getTimeoutUpper",
        value: function () {
          return 6e5
        }
      }, {
        key: "showConversationLoader",
        value: function () {
          $("#conversationLoader").show()
        }
      }, {
        key: "hideConversationLoader",
        value: function () {
          $("#conversationLoader").hide()
        }
      }]), t
    }();
    t.exports = {
      ChatAdapter: o
    }
  }, {
    "../../../api/ConversationsAdapter": 3
  }]
}, {}, [6]);
//# sourceMappingURL=conversations.js.map