!(function () {
    return function e(t, l, a) {
        function i(n, o) {
            if (!l[n]) {
                if (!t[n]) {
                    var s = "function" == typeof require && require;
                    if (!o && s) return s(n, !0);
                    if (r) return r(n, !0);
                    var u = new Error("Cannot find module '" + n + "'");
                    throw ((u.code = "MODULE_NOT_FOUND"), u);
                }
                var c = (l[n] = { exports: {} });
                t[n][0].call(
                    c.exports,
                    function (e) {
                        return i(t[n][1][e] || e);
                    },
                    c,
                    c.exports,
                    e,
                    t,
                    l,
                    a
                );
            }
            return l[n].exports;
        }
        for (var r = "function" == typeof require && require, n = 0; n < a.length; n++) i(a[n]);
        return i;
    };
})()(
    {
        1: [
            function (e, t, l) {
                "use strict";
                var a = e("./lib");
                window.JobAdapter = a.JobAdapter;
            },
            { "./lib": 2 },
        ],
        2: [
            function (e, t, l) {
                "use strict";
                var a,
                    i = (function () {
                        function e(e, t) {
                            for (var l = 0; l < t.length; l++) {
                                var a = t[l];
                                (a.enumerable = a.enumerable || !1), (a.configurable = !0), "value" in a && (a.writable = !0), Object.defineProperty(e, a.key, a);
                            }
                        }
                        return function (t, l, a) {
                            return l && e(t.prototype, l), a && e(t, a), t;
                        };
                    })(),
                    r = e("../../../api/AdapterBase"),
                    n = (a = r) && a.__esModule ? a : { default: a };
                var o = (function (e) {
                    function t() {
                        return (
                            (function (e, t) {
                                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                            })(this, t),
                            (function (e, t) {
                                if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                                return !t || ("object" != typeof t && "function" != typeof t) ? e : t;
                            })(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments))
                        );
                    }
                    return (
                        (function (e, t) {
                            if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                            (e.prototype = Object.create(t && t.prototype, { constructor: { value: e, enumerable: !1, writable: !0, configurable: !0 } })), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : (e.__proto__ = t));
                        })(t, n.default),
                        i(t, [
                            {
                                key: "getDataMapping",
                                value: function () {
                                    return ["id", "code", "title", "shortDescription", "country", "company"];
                                },
                            },
                            {
                                key: "getHeaders",
                                value: function () {
                                    return [{ sTitle: "ID", bVisible: !1 }, { sTitle: "Job Code" }, { sTitle: "Job Title" }, { sTitle: "Details" }, { sTitle: "Country" }, { sTitle: "Department" }];
                                },
                            },
                            {
                                key: "getFormFields",
                                value: function () {
                                    return [
                                        ["id", { label: "ID", type: "hidden" }],
                                        ["code", { label: "Job Code", type: "text" }],
                                        ["title", { label: "Job Title", type: "text" }],
                                        ["positionReason", { label: "Reason for Position", type: "textarea", validation: "" }],
                                        ["companyName", { label: "Company Name", type: "text", validation: "none" }],
                                        ["hiringManager", { label: "Hiring Manager", type: "select", "allow-null": !0, "null-label": "Not Selected", "remote-source": ["Employee", "id", "first_name+middle_name+last_name"] }],
                                        [
                                            "showHiringManager",
                                            {
                                                label: "Show Hiring Manager Name",
                                                type: "select",
                                                source: [
                                                    ["Yes", "Yes"],
                                                    ["No", "No"],
                                                ],
                                            },
                                        ],
                                        ["shortDescription", { label: "Short Description", type: "textarea" }],
                                        ["description", { label: "Job Description", type: "simplemde" }],
                                        ["requirements", { label: "Requirements", type: "simplemde", validation: "none" }],
                                        ["benefits", { label: "Benefits", type: "select2multi", "remote-source": ["Benifit", "name", "name"] }],
                                        ["country", { label: "Country", type: "select2", "allow-null": !1, "remote-source": ["Country", "id", "name"] }],
                                        ["location", { label: "City", type: "text" }],
                                        ["postalCode", { label: "Postal Code", type: "text" }],
                                        ["company", { label: "Department", type: "select2", "allow-null": !0, "remote-source": ["Vw_departments", "id", "title"] }],
                                        ["employementType", { label: "Employement Type", type: "select", "allow-null": !0, "null-label": "Any Employement Type", "remote-source": ["EmployementType", "id", "name"] }],
                                        ["experienceLevel", { label: "Experience Level", type: "select", "allow-null": !0, "null-label": "Any Experience Level", "remote-source": ["ExperienceLevel", "id", "name"] }],
                                        ["jobFunction", { label: "Job Function", type: "select", "allow-null": !0, "null-label": "Any Job Function", "remote-source": ["JobFunction", "id", "name"] }],
                                        ["educationLevel", { label: "Education Level", type: "select", "allow-null": !0, "null-label": "Any Education Level", "remote-source": ["EducationLevel", "id", "name"] }],
                                        [
                                            "showSalary",
                                            {
                                                label: "Show Salary",
                                                type: "select",
                                                source: [
                                                    ["Yes", "Yes"],
                                                    ["No", "No"],
                                                ],
                                            },
                                        ],
                                        ["currency", { label: "Currency", type: "select2", "allow-null": !1, "remote-source": ["CurrencyType", "id", "name"] }],
                                        ["salaryMin", { label: "Salary Min", type: "text", validation: "none" }],
                                        ["salaryMax", { label: "Salary Max", type: "text", validation: "none" }],
                                        ["keywords", { label: "Keywords", type: "text", validation: "none" }],
                                        [
                                            "status",
                                            {
                                                label: "Status",
                                                type: "select",
                                                source: [
                                                    ["Active", "Active"],
                                                    ["On hold", "On hold"],
                                                    ["Closed", "Closed"],
                                                ],
                                            },
                                        ],
                                        ["closingDate", { label: "Closing Date", type: "date", validation: "none" }],
                                        ["attachment", { label: "Image", type: "fileupload", validation: "none" }],
                                        [
                                            "display",
                                            {
                                                label: "Display Type",
                                                type: "select",
                                                sort: "none",
                                                source: [
                                                    ["Text Only", "Text Only"],
                                                    ["Image Only", "Image Only"],
                                                    ["Image and Full Text", "Image and Full Text"],
                                                    ["Image and Other Details", "Image and Other Details"],
                                                ],
                                            },
                                        ],
                                    ];
                                },
                            },
                            {
                                key: "getActionButtonsHtml",
                                value: function (e, t) {
                                    var l = this.getLink(t[1]),
                                        a = '<div style="width:110px;">_edit__delete__linkButton_<hr style="margin-top:5px;margin-bottom:5px"/>_facebookButton__twitterButton__googleButton__linkedinButton_</div>';
                                    return (
                                        (a = this.showDelete
                                            ? a.replace(
                                                  "_delete_",
                                                  '<img class="tableActionButton" src="_BASE_images/delete.png" style="margin-left:15px;cursor:pointer;" rel="tooltip" title="Delete" onclick="modJs.deleteRow(_id_);return false;"></img>'
                                              )
                                            : a.replace("_delete_", "")),
                                        (a = (a = (a = (a = (a = (a = (a = (a = (a = (a = (a = this.showEdit
                                            ? a.replace("_edit_", '<img class="tableActionButton" src="_BASE_images/edit.png" style="cursor:pointer;" rel="tooltip" title="Edit" onclick="modJs.edit(_id_);return false;"></img>')
                                            : a.replace("_edit_", "")).replace(
                                            "_linkButton_",
                                            '<img class="tableActionButton" src="_BASE_images/mime-html.png" style="margin-left:15px;cursor:pointer;" rel="tooltip" title="Job Link" onclick="modJs.showLink(\'_code_\');return false;"></img>'
                                        )).replace(
                                            "_facebookButton_",
                                            '<img class="tableActionButton" src="_BASE_images/facebook-16x16.png" style="cursor:pointer;" rel="tooltip" title="Share on Facebook" onclick="SocialShare.facebook(\'_link_\');return false;"></img>'
                                        )).replace(
                                            "_googleButton_",
                                            '<img class="tableActionButton" src="_BASE_images/google+-16x16.png" style="margin-left:5px;cursor:pointer;" rel="tooltip" title="Share on Google Plus" onclick="SocialShare.google(\'_link_\');return false;"></img>'
                                        )).replace(
                                            "_twitterButton_",
                                            '<img class="tableActionButton" src="_BASE_images/twitter-16x16.png" style="margin-left:5px;cursor:pointer;" rel="tooltip" title="Share on Twitter" onclick="SocialShare.twitter(\'_link_\',\'_msg_\');return false;"></img>'
                                        )).replace(
                                            "_linkedinButton_",
                                            '<img class="tableActionButton" src="_BASE_images/linkedin-16x16.png" style="margin-left:5px;cursor:pointer;" rel="tooltip" title="Share on LinkedIn" onclick="SocialShare.linkedin(\'_link_\');return false;"></img>'
                                        )).replace(/_id_/g, e)).replace(/_code_/g, t[1])).replace(/_link_/g, l)).replace(/_msg_/g, t[2] + " at " + t[6] + ". Apply Now ..")).replace(/_BASE_/g, this.baseUrl))
                                    );
                                },
                            },
                            {
                                key: "getLink",
                                value: function (e) {
                                    return "" + this.getCustomUrl("entry.php?g=admin&n=candidates&ref=") + e;
                                },
                            },
                            {
                                key: "showLink",
                                value: function (e) {
                                    var t = this.getLink(e);
                                    (t = '<input id="linkUrl" value="' + t + '" onclick="this.select();" readonly="readonly" style="width: 100%;background: #EEE;border: none;">'), this.showMessage("Job Url", t);
                                },
                            },
                            {
                                key: "getHelpLink",
                                value: function () {
                                    return "https://icehrm.gitbook.io/icehrm/recruitment/recruitment-management";
                                },
                            },
                        ]),
                        t
                    );
                })();
                t.exports = { JobAdapter: o };
            },
            { "../../../api/AdapterBase": 4 },
        ],
        3: [
            function (e, t, l) {
                "use strict";
                Object.defineProperty(l, "__esModule", { value: !0 });
                var a = (function () {
                    function e(e, t) {
                        for (var l = 0; l < t.length; l++) {
                            var a = t[l];
                            (a.enumerable = a.enumerable || !1), (a.configurable = !0), "value" in a && (a.writable = !0), Object.defineProperty(e, a.key, a);
                        }
                    }
                    return function (t, l, a) {
                        return l && e(t.prototype, l), a && e(t, a), t;
                    };
                })();
                var i = (function () {
                    function e() {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e);
                    }
                    return (
                        a(e, [
                            {
                                key: "getKey",
                                value: function (e, t) {
                                    var l = e + "|";
                                    for (var a in t) l += a + "=" + t[a] + "|";
                                    return l;
                                },
                            },
                            {
                                key: "invalidateTable",
                                value: function (e) {
                                    for (var t = void 0, l = 0; l < localStorage.length; l++) (t = localStorage.key(l)).indexOf("t=" + e) > 0 && localStorage.removeItem(t);
                                },
                            },
                            {
                                key: "getData",
                                value: function (e) {
                                    var t = void 0;
                                    if ("undefined" == typeof Storage) return null;
                                    var l = localStorage.getItem(e);
                                    return void 0 !== l && null != l && "" !== l ? (void 0 === (t = JSON.parse(l)) || null == t ? null : void 0 !== t.status && null != t.status && "SUCCESS" !== t.status ? null : t) : null;
                                },
                            },
                            {
                                key: "setData",
                                value: function (e, t) {
                                    if ("undefined" == typeof Storage) return null;
                                    if (void 0 !== t.status && null != t.status && "SUCCESS" !== t.status) return null;
                                    var l = JSON.stringify(t);
                                    return localStorage.setItem(e, l), l;
                                },
                            },
                        ]),
                        e
                    );
                })();
                l.default = i;
            },
            {},
        ],
        4: [
            function (e, t, l) {
                "use strict";
                Object.defineProperty(l, "__esModule", { value: !0 });
                var a = (function () {
                        function e(e, t) {
                            for (var l = 0; l < t.length; l++) {
                                var a = t[l];
                                (a.enumerable = a.enumerable || !1), (a.configurable = !0), "value" in a && (a.writable = !0), Object.defineProperty(e, a.key, a);
                            }
                        }
                        return function (t, l, a) {
                            return l && e(t.prototype, l), a && e(t, a), t;
                        };
                    })(),
                    i = n(e("./ModuleBase")),
                    r = n(e("../api-common/RequestCache"));
                function n(e) {
                    return e && e.__esModule ? e : { default: e };
                }
                var o = (function (e) {
                    function t(e, l, a, i) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, t);
                        var r = (function (e, t) {
                            if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                            return !t || ("object" != typeof t && "function" != typeof t) ? e : t;
                        })(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this));
                        return (r.moduleRelativeURL = null), (r.tableData = []), (r.sourceData = []), (r.filter = null), (r.origFilter = null), (r.orderBy = null), (r.currentElement = null), r.initAdapter(e, l, a, i), r;
                    }
                    return (
                        (function (e, t) {
                            if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                            (e.prototype = Object.create(t && t.prototype, { constructor: { value: e, enumerable: !1, writable: !0, configurable: !0 } })), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : (e.__proto__ = t));
                        })(t, i.default),
                        a(t, [
                            {
                                key: "initAdapter",
                                value: function (e, t, l, a) {
                                    (this.moduleRelativeURL = baseUrl),
                                        (this.table = e),
                                        (this.tab = null == t ? e : t),
                                        (this.filter = null == l ? null : l),
                                        (this.origFilter = this.filter),
                                        (this.orderBy = null == a ? null : a),
                                        this.trackEvent("initAdapter", t),
                                        (this.requestCache = new r.default());
                                },
                            },
                            {
                                key: "setFilter",
                                value: function (e) {
                                    this.filter = e;
                                },
                            },
                            {
                                key: "preSetFilterExternal",
                                value: function (e) {
                                    this.initialFilter = e;
                                },
                            },
                            {
                                key: "setFilterExternal",
                                value: function (e) {
                                    var t = e;
                                    null == t && (t = this.initialFilter),
                                        null != t && (this.setFilter(t), (this.filtersAlreadySet = !0), $("#" + this.getTableName() + "_resetFilters").show(), (this.currentFilterString = this.getFilterString(t)));
                                },
                            },
                            {
                                key: "getFilter",
                                value: function () {
                                    return this.filter;
                                },
                            },
                            {
                                key: "setOrderBy",
                                value: function (e) {
                                    this.orderBy = e;
                                },
                            },
                            {
                                key: "getOrderBy",
                                value: function () {
                                    return this.orderBy;
                                },
                            },
                            {
                                key: "add",
                                value: function (e, t, l, a) {
                                    var i = this;
                                    null == l && (l = !0),
                                        $(e).attr("a", "add"),
                                        $(e).attr("t", this.table),
                                        i.showLoader(),
                                        this.requestCache.invalidateTable(this.table),
                                        $.post(
                                            this.moduleRelativeURL,
                                            e,
                                            function (e) {
                                                "SUCCESS" === e.status ? i.addSuccessCallBack(t, e.object, l, a, i) : i.addFailCallBack(t, e.object);
                                            },
                                            "json"
                                        ).always(function () {
                                            i.hideLoader();
                                        }),
                                        this.trackEvent("add", this.tab, this.table);
                                },
                            },
                            {
                                key: "addSuccessCallBack",
                                value: function (e, t, l, a, i) {
                                    l && this.get(e), this.initFieldMasterData(), null != a && a.apply(i, [t]), this.trackEvent("addSuccess", this.tab, this.table);
                                },
                            },
                            {
                                key: "addFailCallBack",
                                value: function (e, t) {
                                    try {
                                        this.closePlainMessage();
                                    } catch (e) {}
                                    this.showMessage("Error saving", t), this.trackEvent("addFailed", this.tab, this.table);
                                },
                            },
                            {
                                key: "deleteObj",
                                value: function (e, t) {
                                    var l = this;
                                    l.showLoader(),
                                        this.requestCache.invalidateTable(this.table),
                                        $.post(
                                            this.moduleRelativeURL,
                                            { t: this.table, a: "delete", id: e },
                                            function (e) {
                                                "SUCCESS" === e.status ? l.deleteSuccessCallBack(t, e.object) : l.deleteFailCallBack(t, e.object);
                                            },
                                            "json"
                                        ).always(function () {
                                            l.hideLoader();
                                        }),
                                        this.trackEvent("delete", this.tab, this.table);
                                },
                            },
                            {
                                key: "deleteSuccessCallBack",
                                value: function (e, t) {
                                    this.get(e), this.clearDeleteParams();
                                },
                            },
                            {
                                key: "deleteFailCallBack",
                                value: function (e, t) {
                                    this.clearDeleteParams(), this.showMessage("Error Occurred while Deleting Item", t);
                                },
                            },
                            {
                                key: "get",
                                value: function (e) {
                                    var t = this;
                                    if (this.getRemoteTable()) return this.createTableServer(this.getTableName()), $("#" + this.getTableName() + "Form").hide(), void $("#" + this.getTableName()).show();
                                    var l = JSON.stringify(this.getSourceMapping()),
                                        a = "";
                                    null !== this.getFilter() && (a = JSON.stringify(this.getFilter()));
                                    var i = "";
                                    null !== this.getOrderBy() && (i = this.getOrderBy()),
                                        (l = this.fixJSON(l)),
                                        (a = this.fixJSON(a)),
                                        t.showLoader(),
                                        $.post(
                                            this.moduleRelativeURL,
                                            { t: this.table, a: "get", sm: l, ft: a, ob: i },
                                            function (l) {
                                                "SUCCESS" === l.status ? t.getSuccessCallBack(e, l.object) : t.getFailCallBack(e, l.object);
                                            },
                                            "json"
                                        ).always(function () {
                                            t.hideLoader();
                                        }),
                                        t.initFieldMasterData(),
                                        this.trackEvent("get", this.tab, this.table);
                                },
                            },
                            {
                                key: "getDataUrl",
                                value: function (e) {
                                    var t = JSON.stringify(this.getSourceMapping()),
                                        l = JSON.stringify(e),
                                        a = "";
                                    null !== this.getFilter() && (a = JSON.stringify(this.getFilter()));
                                    var i = "";
                                    null !== this.getOrderBy() && (i = this.getOrderBy());
                                    var r = this.moduleRelativeURL.replace("service.php", "data.php");
                                    return (
                                        (r = (r = (r = (r = (r = r + "?t=" + this.table) + "&sm=" + this.fixJSON(t)) + "&cl=" + this.fixJSON(l)) + "&ft=" + this.fixJSON(a)) + "&ob=" + i),
                                        this.isSubProfileTable() && (r += "&type=sub"),
                                        this.remoteTableSkipProfileRestriction() && (r += "&skip=1"),
                                        r
                                    );
                                },
                            },
                            {
                                key: "isSubProfileTable",
                                value: function () {
                                    return !1;
                                },
                            },
                            {
                                key: "remoteTableSkipProfileRestriction",
                                value: function () {
                                    return !1;
                                },
                            },
                            {
                                key: "preProcessTableData",
                                value: function (e) {
                                    return e;
                                },
                            },
                            {
                                key: "getSuccessCallBack",
                                value: function (e, t) {
                                    for (var l = [], a = this.getDataMapping(), i = 0; i < t.length; i++) {
                                        for (var r = [], n = 0; n < a.length; n++) r[n] = t[i][a[n]];
                                        l.push(this.preProcessTableData(r));
                                    }
                                    (this.sourceData = t),
                                        void 0 !== e.callBack &&
                                            null !== e.callBack &&
                                            ((void 0 !== e.callBackData && null !== e.callBackData) || (e.callBackData = []), e.callBackData.push(t), e.callBackData.push(l), this.callFunction(e.callBack, e.callBackData)),
                                        (this.tableData = l),
                                        (void 0 !== e.noRender && null !== e.noRender && !0 === e.noRender) || (this.createTable(this.getTableName()), $("#" + this.getTableName() + "Form").hide(), $("#" + this.getTableName()).show());
                                },
                            },
                            { key: "getFailCallBack", value: function (e, t) {} },
                            {
                                key: "getElement",
                                value: function (e, t, l) {
                                    var a = this,
                                        i = JSON.stringify(this.getSourceMapping());
                                    (i = this.fixJSON(i)),
                                        a.showLoader(),
                                        $.post(
                                            this.moduleRelativeURL,
                                            { t: this.table, a: "getElement", id: e, sm: i },
                                            function (e) {
                                                "SUCCESS" === e.status ? (l && delete e.object.id, (this.currentElement = e.object), a.getElementSuccessCallBack.apply(a, [t, e.object])) : a.getElementFailCallBack.apply(a, [t, e.object]);
                                            },
                                            "json"
                                        ).always(function () {
                                            a.hideLoader();
                                        }),
                                        this.trackEvent("getElement", this.tab, this.table);
                                },
                            },
                            {
                                key: "getElementSuccessCallBack",
                                value: function (e, t) {
                                    void 0 !== e.callBack &&
                                        null !== e.callBack &&
                                        ((void 0 !== e.callBackData && null !== e.callBackData) || (e.callBackData = []), e.callBackData.push(t), this.callFunction(e.callBack, e.callBackData, this)),
                                        (this.currentElement = t),
                                        (void 0 !== e.noRender && null !== e.noRender && !0 === e.noRender) || this.renderForm(t);
                                },
                            },
                            { key: "getElementFailCallBack", value: function (e, t) {} },
                            {
                                key: "getTableData",
                                value: function () {
                                    return this.tableData;
                                },
                            },
                            {
                                key: "getTableName",
                                value: function () {
                                    return this.tab;
                                },
                            },
                            {
                                key: "getFieldValues",
                                value: function (e, t) {
                                    var l = this,
                                        a = "",
                                        i = "";
                                    void 0 !== e[3] && null !== e[3] && (a = e[3]), void 0 !== e[4] && null !== e[4] && (i = JSON.stringify(e[4]));
                                    var r = this.requestCache.getKey(this.moduleRelativeURL, { t: e[0], key: e[1], value: e[2], method: a, methodParams: i, a: "getFieldValues" }),
                                        n = this.requestCache.getData(r);
                                    null != n &&
                                        "SUCCESS" === n.status &&
                                        (t.callBackData.push(n.data), null !== t.callBackSuccess && void 0 !== t.callBackSuccess && t.callBackData.push(t.callBackSuccess), l.callFunction(t.callBack, t.callBackData));
                                    var o = function e(a) {
                                        if ("SUCCESS" === a.status) {
                                            l.requestCache.setData(this.success.key, a);
                                            var i = t;
                                            (i.callBackData = [t.callBackData[0]]),
                                                i.callBackData.push(a.data),
                                                null !== i.callBackSuccess && void 0 !== i.callBackSuccess && i.callBackData.push(t.callBackSuccess),
                                                l.callFunction(i.callBack, i.callBackData);
                                        } else "Access violation" === a.message && alert("Error : " + e.table + " " + a.message);
                                    };
                                    (o.key = r), (o.table = e[0]), $.post(this.moduleRelativeURL, { t: e[0], key: e[1], value: e[2], method: a, methodParams: i, a: "getFieldValues" }, o, "json");
                                },
                            },
                            {
                                key: "setAdminProfile",
                                value: function (e) {
                                    try {
                                        localStorage.clear();
                                    } catch (e) {}
                                    $.post(
                                        this.moduleRelativeURL,
                                        { a: "setAdminEmp", empid: e },
                                        function () {
                                            top.location.href = clientUrl;
                                        },
                                        "json"
                                    );
                                },
                            },
                            {
                                key: "customAction",
                                value: function (e, t, l, a, i) {
                                    var r = this;
                                    (l = this.fixJSON(l)),
                                        i
                                            ? $.post(
                                                  this.moduleRelativeURL,
                                                  { t: this.table, a: "ca", sa: e, mod: t, req: l },
                                                  function (e) {
                                                      "SUCCESS" === e.status ? (a.callBackData.push(e.data), r.callFunction(a.callBackSuccess, a.callBackData)) : (a.callBackData.push(e.data), r.callFunction(a.callBackFail, a.callBackData));
                                                  },
                                                  "json"
                                              )
                                            : $.getJSON(this.moduleRelativeURL, { t: this.table, a: "ca", sa: e, mod: t, req: l }, function (e) {
                                                  "SUCCESS" === e.status ? (a.callBackData.push(e.data), r.callFunction(a.callBackSuccess, a.callBackData)) : (a.callBackData.push(e.data), r.callFunction(a.callBackFail, a.callBackData));
                                              });
                                },
                            },
                            {
                                key: "sendCustomRequest",
                                value: function (e, t, l, a) {
                                    (t.a = e),
                                        $.post(
                                            this.moduleRelativeURL,
                                            t,
                                            function (e) {
                                                "SUCCESS" === e.status ? l(e.data) : a(e.data);
                                            },
                                            "json"
                                        );
                                },
                            },
                            {
                                key: "getCustomActionUrl",
                                value: function (e, t) {
                                    t.a = e;
                                    var l = "";
                                    for (var a in t) t.hasOwnProperty(a) && ("" !== l && (l += "&"), (l += a + "=" + t[a]));
                                    return this.moduleRelativeURL + "?" + l;
                                },
                            },
                            {
                                key: "getClientDataUrl",
                                value: function () {
                                    return this.moduleRelativeURL.replace("service.php", "") + "data/";
                                },
                            },
                            {
                                key: "getCustomUrl",
                                value: function (e) {
                                    return this.moduleRelativeURL.replace("service.php", e);
                                },
                            },
                        ]),
                        t
                    );
                })();
                l.default = o;
            },
            { "../api-common/RequestCache": 3, "./ModuleBase": 6 },
        ],
        5: [
            function (e, t, l) {
                "use strict";
                Object.defineProperty(l, "__esModule", { value: !0 });
                var a = (function () {
                    function e(e, t) {
                        for (var l = 0; l < t.length; l++) {
                            var a = t[l];
                            (a.enumerable = a.enumerable || !1), (a.configurable = !0), "value" in a && (a.writable = !0), Object.defineProperty(e, a.key, a);
                        }
                    }
                    return function (t, l, a) {
                        return l && e(t.prototype, l), a && e(t, a), t;
                    };
                })();
                var i = {
                        float: function (e) {
                            return !(null == e || !e.match(/^[-+]?[0-9]+(\.[0-9]+)?$/));
                        },
                        number: function (e) {
                            return !(null == e || !e.match(/^[0-9]+$/));
                        },
                        numberOrEmpty: function (e) {
                            if ("" === e) return !0;
                            return !(null == e || !e.match(/^[0-9]+$/));
                        },
                        email: function (e) {
                            return null != e && /^\s*[\w\-+_]+(\.[\w\-+_]+)*@[\w\-+_]+\.[\w\-+_]+(\.[\w\-+_]+)*\s*$/.test(e);
                        },
                        emailOrEmpty: function (e) {
                            if ("" === e) return !0;
                            return null != e && /^\s*[\w\-+_]+(\.[\w\-+_]+)*@[\w\-+_]+\.[\w\-+_]+(\.[\w\-+_]+)*\s*$/.test(e);
                        },
                        username: function (e) {
                            return null != e && /^[a-zA-Z0-9.-]+$/.test(e);
                        },
                        input: function (e) {
                            return null != e && e.length > 0;
                        },
                    },
                    r = (function () {
                        function e(t, l, a) {
                            !(function (e, t) {
                                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                            })(this, e),
                                (this.tempOptions = {}),
                                (this.formId = t),
                                (this.formError = !1),
                                (this.formObject = null),
                                (this.errorMessages = ""),
                                (this.popupDialog = null),
                                (this.validateAll = l),
                                (this.errorMap = []),
                                (this.settings = { thirdPartyPopup: null, LabelErrorClass: !1, ShowPopup: !0 }),
                                (this.settings = jQuery.extend(this.settings, a)),
                                (this.inputTypes = ["text", "radio", "checkbox", "file", "password", "select-one", "select-multi", "textarea", "fileupload", "signature"]),
                                (this.validator = i);
                        }
                        return (
                            a(
                                e,
                                [
                                    {
                                        key: "clearError",
                                        value: function (e, t) {
                                            var l = e.attr("id");
                                            $("#" + this.formId + " #field_" + l).removeClass("error"), $("#" + this.formId + " #help_" + l).html("");
                                        },
                                    },
                                    {
                                        key: "addError",
                                        value: function (e, t) {
                                            (this.formError = !0), null != e.attr("message") ? ((this.errorMessages += e.attr("message") + "\n"), (this.errorMap[e.attr("name")] = e.attr("message"))) : (this.errorMap[e.attr("name")] = "");
                                            var l = e.attr("id"),
                                                a = e.attr("validation"),
                                                i = e.attr("validation");
                                            $("#" + this.formId + " #field_" + l).addClass("error"),
                                                void 0 === i || null == i || "" === i
                                                    ? $("#" + this.formId + " #help_err_" + l).html(i)
                                                    : void 0 === a || null == a || "" === a
                                                    ? $("#" + this.formId + " #help_err_" + l).html("Required")
                                                    : "float" === a || "number" === a
                                                    ? $("#" + this.formId + " #help_err_" + l).html("Number required")
                                                    : "email" === a
                                                    ? $("#" + this.formId + " #help_err_" + l).html("Email required")
                                                    : $("#" + this.formId + " #help_err_" + l).html("Required");
                                        },
                                    },
                                    {
                                        key: "showErrors",
                                        value: function () {
                                            this.formError &&
                                                (void 0 !== this.settings.thirdPartyPopup && null != this.settings.thirdPartyPopup
                                                    ? this.settings.thirdPartyPopup.alert()
                                                    : !0 === this.settings.ShowPopup &&
                                                      (void 0 !== this.tempOptions.popupTop && null != this.tempOptions.popupTop
                                                          ? this.alert("Errors Found", this.errorMessages, this.tempOptions.popupTop)
                                                          : this.alert("Errors Found", this.errorMessages, -1)));
                                        },
                                    },
                                    {
                                        key: "checkValues",
                                        value: function (e) {
                                            this.tempOptions = e;
                                            var t = this;
                                            (this.formError = !1), (this.errorMessages = ""), (this.formObject = {});
                                            var l = function (e) {
                                                    var l = null,
                                                        a = e.attr("name");
                                                    !1 !== t.settings.LabelErrorClass && $("label[for='" + a + "']").removeClass(t.settings.LabelErrorClass);
                                                    var i = e.attr("id"),
                                                        r = e.attr("type");
                                                    if (e.hasClass("select2-focusser") || e.hasClass("select2-input")) return !0;
                                                    if (jQuery.inArray(r, t.inputTypes) >= 0) {
                                                        if (e.hasClass("uploadInput")) l = e.attr("val");
                                                        else if ("radio" === r || "checkbox" === r) l = $("input[name='" + a + "']:checked").val();
                                                        else if (e.hasClass("select2Field"))
                                                            l = null != $("#" + t.formId + " #" + i).select2("data") && void 0 !== $("#" + t.formId + " #" + i).select2("data") ? $("#" + t.formId + " #" + i).select2("data").id : "";
                                                        else if (e.hasClass("select2Multi"))
                                                            if (null != $("#" + t.formId + " #" + i).select2("data") && void 0 !== $("#" + t.formId + " #" + i).select2("data")) {
                                                                var n = $("#" + t.formId + " #" + i).select2("data");
                                                                l = [];
                                                                for (var o = 0; o < n.length; o++) l.push(n[o].id);
                                                                l = JSON.stringify(l);
                                                            } else l = "";
                                                        else
                                                            l = e.hasClass("signatureField")
                                                                ? $("#" + t.formId + " #" + i)
                                                                      .data("signaturePad")
                                                                      .isEmpty()
                                                                    ? ""
                                                                    : $("#" + i)
                                                                          .data("signaturePad")
                                                                          .toDataURL()
                                                                : e.hasClass("simplemde")
                                                                ? $("#" + t.formId + " #" + i)
                                                                      .data("simplemde")
                                                                      .value()
                                                                : e.hasClass("tinymce")
                                                                ? tinyMCE.get(i).getContent({ format: "raw" })
                                                                : e.val();
                                                        var s = e.attr("validation"),
                                                            u = !1;
                                                        void 0 !== s && null != s && void 0 !== t.validator[s] && null != t.validator[s]
                                                            ? (u = t.validator[s](l))
                                                            : ((u = !t.validateAll || (void 0 !== s && null != s && "none" === s) || t.validator.input(l)), (t.formObject[i] = l)),
                                                            u ? (t.clearError(e, null), (t.formObject[i] = l)) : t.addError(e, null);
                                                    }
                                                },
                                                a = $("#" + this.formId + " :input");
                                            return (
                                                a.each(function () {
                                                    l($(this));
                                                }),
                                                (a = $("#" + this.formId + " .uploadInput")).each(function () {
                                                    l($(this));
                                                }),
                                                this.showErrors(),
                                                (this.tempOptions = {}),
                                                !this.formError
                                            );
                                        },
                                    },
                                    {
                                        key: "getFormParameters",
                                        value: function () {
                                            return this.formObject;
                                        },
                                    },
                                    {
                                        key: "alert",
                                        value: (function (e) {
                                            function t(t, l) {
                                                return e.apply(this, arguments);
                                            }
                                            return (
                                                (t.toString = function () {
                                                    return e.toString();
                                                }),
                                                t
                                            );
                                        })(function (e, t) {
                                            alert(t);
                                        }),
                                    },
                                ],
                                [
                                    {
                                        key: "getValidationRules",
                                        value: function () {
                                            return i;
                                        },
                                    },
                                ]
                            ),
                            e
                        );
                    })();
                l.default = r;
            },
            {},
        ],
        6: [
            function (e, t, l) {
                "use strict";
                Object.defineProperty(l, "__esModule", { value: !0 });
                var a,
                    i = (function () {
                        function e(e, t) {
                            for (var l = 0; l < t.length; l++) {
                                var a = t[l];
                                (a.enumerable = a.enumerable || !1), (a.configurable = !0), "value" in a && (a.writable = !0), Object.defineProperty(e, a.key, a);
                            }
                        }
                        return function (t, l, a) {
                            return l && e(t.prototype, l), a && e(t, a), t;
                        };
                    })(),
                    r = e("./FormValidation"),
                    n = (a = r) && a.__esModule ? a : { default: a };
                var o = (function () {
                    function e() {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this.deleteParams = {}),
                            (this.createRemoteTable = !1),
                            (this.instanceId = "None"),
                            (this.ga = []),
                            (this.showEdit = !0),
                            (this.showDelete = !0),
                            (this.showSave = !0),
                            (this.showCancel = !0),
                            (this.showFormOnPopup = !1),
                            (this.filtersAlreadySet = !1),
                            (this.currentFilterString = ""),
                            (this.sorting = 0),
                            (this.settings = {}),
                            (this.translations = {}),
                            (this.customFields = []),
                            (this.csrfRequired = !1),
                            (this.fieldTemplates = null),
                            (this.templates = null),
                            (this.customTemplates = null),
                            (this.emailTemplates = null),
                            (this.fieldMasterData = null),
                            (this.fieldMasterDataKeys = null),
                            (this.fieldMasterDataCallback = null),
                            (this.sourceMapping = null),
                            (this.currentId = null),
                            (this.currentElement = null),
                            (this.user = null),
                            (this.currentProfile = null),
                            (this.permissions = {}),
                            (this.baseUrl = null);
                    }
                    return (
                        i(e, [
                            { key: "init", value: function (e, t, l, a) {} },
                            {
                                key: "setNoJSONRequests",
                                value: function (e) {
                                    this.noJSONRequests = e;
                                },
                            },
                            {
                                key: "setPermissions",
                                value: function (e) {
                                    this.permissions = e;
                                },
                            },
                            {
                                key: "sortingStarted",
                                value: function (e) {
                                    this.sorting = e;
                                },
                            },
                            {
                                key: "checkPermission",
                                value: function (e) {
                                    return void 0 === this.permissions[e] || null == this.permissions[e] || "Yes" === this.permissions[e] ? "Yes" : this.permissions[e];
                                },
                            },
                            {
                                key: "setBaseUrl",
                                value: function (e) {
                                    this.baseUrl = e;
                                },
                            },
                            {
                                key: "setUser",
                                value: function (e) {
                                    this.user = e;
                                },
                            },
                            {
                                key: "getUser",
                                value: function () {
                                    return this.user;
                                },
                            },
                            {
                                key: "setInstanceId",
                                value: function (e) {
                                    this.instanceId = e;
                                },
                            },
                            {
                                key: "setCSRFRequired",
                                value: function (e) {
                                    this.csrfRequired = e;
                                },
                            },
                            {
                                key: "scrollToTop",
                                value: function () {
                                    $("html, body").animate({ scrollTop: 0 }, "fast");
                                },
                            },
                            {
                                key: "scrollToBottom",
                                value: function () {
                                    $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                                },
                            },
                            {
                                key: "scrollToElement",
                                value: function (e) {
                                    $(window).height() <= e.offset().top && $("html, body").animate({ scrollTop: e.offset().top }, "slow");
                                },
                            },
                            {
                                key: "scrollToElementBottom",
                                value: function (e) {
                                    $(window).height() <= e.offset().top + e.height() && $("html, body").animate({ scrollTop: e.offset().top + e.height() }, "slow");
                                },
                            },
                            {
                                key: "setTranslations",
                                value: function (e) {
                                    this.translations = e.messages[""];
                                },
                            },
                            {
                                key: "setTranslationsSubModules",
                                value: function (e) {
                                    this.translations = e;
                                },
                            },
                            {
                                key: "gt",
                                value: function (e) {
                                    return void 0 === this.translations[e] || null === this.translations[e] ? e : this.translations[e][0];
                                },
                            },
                            {
                                key: "addToLangTerms",
                                value: function (e) {
                                    var t = void 0,
                                        l = localStorage.getItem("terms");
                                    if (void 0 === l) t = {};
                                    else
                                        try {
                                            t = JSON.parse(l);
                                        } catch (e) {
                                            t = {};
                                        }
                                    void 0 === this.translations[e] && ((t[e] = e), localStorage.setItem("terms", JSON.stringify(t)));
                                },
                            },
                            {
                                key: "showActionButtons",
                                value: function () {
                                    return !0;
                                },
                            },
                            {
                                key: "trackEvent",
                                value: function (e, t, l) {
                                    try {
                                        void 0 === t || null == t
                                            ? this.ga.push(["_trackEvent", this.instanceId, e])
                                            : void 0 === l || null == l
                                            ? this.ga.push(["_trackEvent", this.instanceId, e, t])
                                            : this.ga.push(["_trackEvent", this.instanceId, e, t, l]);
                                    } catch (e) {}
                                },
                            },
                            {
                                key: "setCurrentProfile",
                                value: function (e) {
                                    this.currentProfile = e;
                                },
                            },
                            {
                                key: "getCurrentProfile",
                                value: function () {
                                    return this.currentProfile;
                                },
                            },
                            {
                                key: "initFieldMasterData",
                                value: function (e, t, l) {
                                    var a = void 0;
                                    (void 0 !== this.showAddNew && null != this.showAddNew) || (this.showAddNew = !0),
                                        (this.fieldMasterData = {}),
                                        (this.fieldMasterDataKeys = {}),
                                        (this.fieldMasterDataCallback = t),
                                        (this.fieldMasterDataCallbackData = l),
                                        (this.sourceMapping = {});
                                    var i = this.getFormFields(),
                                        r = this.getFilters();
                                    if (null != r) for (var n = 0; n < r.length; n++) (null == (a = this.getMetaFieldValues(r[n][0], i)) || ("select" !== a.type && "select2" !== a.type && "select2multi" !== a.type)) && i.push(r[n]);
                                    for (var o = [], s = [], u = null, c = null, d = 0; d < i.length; d++)
                                        if (void 0 !== (u = i[d])[1]["remote-source"] && null !== u[1]["remote-source"]) {
                                            var h = u[1]["remote-source"][0] + "_" + u[1]["remote-source"][1] + "_" + u[1]["remote-source"][2];
                                            o.push(u), s.push(h);
                                        } else if (void 0 !== u[1].form && null !== u[1].form)
                                            for (var f = 0; f < u[1].form.length; f++)
                                                if (void 0 !== (c = u[1].form[f])[1]["remote-source"] && null !== c[1]["remote-source"]) {
                                                    var p = c[1]["remote-source"][0] + "_" + c[1]["remote-source"][1] + "_" + c[1]["remote-source"][2];
                                                    s.indexOf(p) < 0 && (o.push(c), s.push(p));
                                                }
                                    for (var m = 0; m < o.length; m++) {
                                        var v = o[m];
                                        if (void 0 !== v[1]["remote-source"] && null != v[1]["remote-source"]) {
                                            var g = v[1]["remote-source"][0] + "_" + v[1]["remote-source"][1] + "_" + v[1]["remote-source"][2];
                                            (this.fieldMasterDataKeys[g] = !1), (this.sourceMapping[v[0]] = v[1]["remote-source"]);
                                            var y = { callBack: "initFieldMasterDataResponse" };
                                            (y.callBackData = [g]), null != e && (y.callBackSuccess = e), this.getFieldValues(v[1]["remote-source"], y);
                                        }
                                    }
                                },
                            },
                            {
                                key: "setShowFormOnPopup",
                                value: function (e) {
                                    this.showFormOnPopup = e;
                                },
                            },
                            {
                                key: "setRemoteTable",
                                value: function (e) {
                                    this.createRemoteTable = e;
                                },
                            },
                            {
                                key: "setSettings",
                                value: function (e) {
                                    this.settings = e;
                                },
                            },
                            {
                                key: "getRemoteTable",
                                value: function () {
                                    return this.createRemoteTable;
                                },
                            },
                            {
                                key: "isAllLoaded",
                                value: function (e) {
                                    for (var t in e) if (!1 === e[t]) return !1;
                                    return !0;
                                },
                            },
                            {
                                key: "initFieldMasterDataResponse",
                                value: function (e, t, l, a) {
                                    (this.fieldMasterData[e] = t),
                                        (this.fieldMasterDataKeys[e] = !0),
                                        null != l && l(),
                                        null !== this.fieldMasterDataCallback &&
                                        void 0 !== this.fieldMasterDataCallback &&
                                        this.isAllLoaded(this.fieldMasterDataKeys) &&
                                        null !== this.fieldMasterDataCallbackData &&
                                        void 0 !== this.fieldMasterDataCallbackData
                                            ? this.fieldMasterDataCallback(this.fieldMasterDataCallbackData)
                                            : null !== this.fieldMasterDataCallback && void 0 !== this.fieldMasterDataCallback && this.isAllLoaded(this.fieldMasterDataKeys) && this.fieldMasterDataCallback();
                                },
                            },
                            {
                                key: "getMetaFieldValues",
                                value: function (e, t) {
                                    for (var l = 0; l < t.length; l++) if (e === t[l][0]) return t[l][1];
                                    return null;
                                },
                            },
                            {
                                key: "getThemeColors",
                                value: function () {
                                    return ["red", "yellow", "aqua", "blue", "light-blue", "green", "navy", "teal", "olive", "orange", "fuchsia", "purple"];
                                },
                            },
                            {
                                key: "getColorByRandomString",
                                value: function (e) {
                                    var t = this.getThemeColors();
                                    return t[e.charCodeAt(0) % t.length];
                                },
                            },
                            {
                                key: "getColorByFileType",
                                value: function (e) {
                                    e = e.toLowerCase();
                                    var t = { pdf: "red", csv: "yellow", xls: "green", xlsx: "green", doc: "light-blue", docx: "light-blue" };
                                    return (
                                        (t.docx = "blue"),
                                        (t.ppt = "orange"),
                                        (t.pptx = "orange"),
                                        (t.jpg = "teal"),
                                        (t.jpeg = "teal"),
                                        (t.gif = "green"),
                                        (t.png = "yellow"),
                                        (t.bmp = "fuchsia"),
                                        void 0 !== t[e] || null != t[e] ? t[e] : this.getColorByRandomString(e)
                                    );
                                },
                            },
                            {
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
                                        rtf: "fa fa-file-text-o",
                                    };
                                    return void 0 !== t[(e = e.toLowerCase())] || null != t[e] ? t[e] : "fa fa-file-o";
                                },
                            },
                            {
                                key: "getSourceMapping",
                                value: function () {
                                    return this.sourceMapping;
                                },
                            },
                            {
                                key: "setTesting",
                                value: function (e) {
                                    this.testing = e;
                                },
                            },
                            {
                                key: "consoleLog",
                                value: function (e) {
                                    this.testing && console.log(e);
                                },
                            },
                            {
                                key: "setClientMessages",
                                value: function (e) {
                                    this.msgList = e;
                                },
                            },
                            {
                                key: "setTemplates",
                                value: function (e) {
                                    this.templates = e;
                                },
                            },
                            {
                                key: "getWSProperty",
                                value: function (e, t) {
                                    return e.hasOwnProperty(t) ? e[t] : null;
                                },
                            },
                            {
                                key: "getClientMessage",
                                value: function (e) {
                                    return this.getWSProperty(this.msgList, e);
                                },
                            },
                            {
                                key: "getTemplate",
                                value: function (e) {
                                    return this.getWSProperty(this.templates, e);
                                },
                            },
                            {
                                key: "setGoogleAnalytics",
                                value: function (e) {
                                    this.gaq = e;
                                },
                            },
                            {
                                key: "showView",
                                value: function (e) {
                                    null != this.currentView && ((this.previousView = this.currentView), $("#" + this.currentView).hide()), $("#" + e).show(), (this.currentView = e), this.moveToTop();
                                },
                            },
                            {
                                key: "showPreviousView",
                                value: function () {
                                    this.showView(this.previousView);
                                },
                            },
                            { key: "moveToTop", value: function () {} },
                            {
                                key: "callFunction",
                                value: function (e, t, l) {
                                    if ($.isFunction(e))
                                        try {
                                            null == l ? e.apply(document, t) : e.apply(l, t);
                                        } catch (e) {
                                            console.log(e.message);
                                        }
                                    else {
                                        var a = this[e];
                                        if ($.isFunction(a))
                                            try {
                                                a.apply(this, t);
                                            } catch (e) {
                                                console.log(e.message);
                                            }
                                    }
                                },
                            },
                            {
                                key: "getTableTopButtonHtml",
                                value: function () {
                                    var e = "";
                                    return (
                                        this.getShowAddNew() && (e = '<button onclick="modJs.renderForm();return false;" class="btn btn-small btn-primary">' + this.gt(this.getAddNewLabel()) + ' <i class="fa fa-plus"></i></button>'),
                                        null != this.getFilters() &&
                                            ("" !== e && (e += "&nbsp;&nbsp;"),
                                            (e += '<button onclick="modJs.showFilters();return false;" class="btn btn-small btn-primary">' + this.gt("Filter") + ' <i class="fa fa-filter"></i></button>'),
                                            (e += "&nbsp;&nbsp;"),
                                            this.filtersAlreadySet
                                                ? (e += '<button id="__id___resetFilters" onclick="modJs.resetFilters();return false;" class="btn btn-small btn-default">__filterString__ <i class="fa fa-times"></i></button>')
                                                : (e +=
                                                      '<button id="__id___resetFilters" onclick="modJs.resetFilters();return false;" class="btn btn-small btn-default" style="display:none;">__filterString__ <i class="fa fa-times"></i></button>')),
                                        (e = e.replace(/__id__/g, this.getTableName())),
                                        "" !== (e = "" !== this.currentFilterString && null != this.currentFilterString ? e.replace(/__filterString__/g, this.currentFilterString) : e.replace(/__filterString__/g, "Reset Filters")) &&
                                            (e = '<div class="row"><div class="col-xs-12">' + e + "</div></div>"),
                                        e
                                    );
                                },
                            },
                            {
                                key: "getActionButtonHeader",
                                value: function () {
                                    return { sTitle: "", sClass: "center" };
                                },
                            },
                            {
                                key: "getTableHTMLTemplate",
                                value: function () {
                                    return '<div class="box-body table-responsive"><table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped" id="grid"></table></div>';
                                },
                            },
                            {
                                key: "isSortable",
                                value: function () {
                                    return !0;
                                },
                            },
                            {
                                key: "createTable",
                                value: function (e) {
                                    if (this.getRemoteTable()) this.createTableServer(e);
                                    else {
                                        var t = this.getHeaders();
                                        for (var l in t) t[l].sTitle = this.gt(t[l].sTitle);
                                        var a = this.getTableData();
                                        if ((this.showActionButtons() && t.push(this.getActionButtonHeader()), this.showActionButtons())) for (var i = 0; i < a.length; i++) a[i].push(this.getActionButtonsHtml(a[i][0], a[i]));
                                        var r;
                                        r = this.getTableTopButtonHtml() + this.getTableHTMLTemplate();
                                        var n = $("#" + e + " .dataTables_paginate .active a").html(),
                                            o = 0;
                                        void 0 !== n && null != n && (o = 15 * parseInt(n, 10) - 15), $("#" + e).html(r);
                                        var s = { oLanguage: { sLengthMenu: "_MENU_ records per page" }, aaData: a, aoColumns: t, bSort: this.isSortable(), iDisplayLength: 15, iDisplayStart: o },
                                            u = this.getCustomTableParams();
                                        $.extend(s, u),
                                            $("#" + e + " #grid").dataTable(s),
                                            $(".dataTables_paginate ul").addClass("pagination"),
                                            $(".dataTables_length").hide(),
                                            $(".dataTables_filter input").addClass("form-control"),
                                            $(".dataTables_filter input").attr("placeholder", "Search"),
                                            $(".dataTables_filter label")
                                                .contents()
                                                .filter(function () {
                                                    return 3 === this.nodeType;
                                                })
                                                .remove(),
                                            $(".tableActionButton").tooltip();
                                    }
                                },
                            },
                            {
                                key: "createTableServer",
                                value: function (e) {
                                    var t = this.getHeaders();
                                    for (var l in (t.push({ sTitle: "", sClass: "center" }), t)) t[l].sTitle = this.gt(t[l].sTitle);
                                    var a;
                                    a = this.getTableTopButtonHtml() + this.getTableHTMLTemplate();
                                    var i = $("#" + e + " .dataTables_paginate .active a").html(),
                                        r = 0;
                                    void 0 !== i && null != i && (r = 15 * parseInt(i, 10) - 15), $("#" + e).html(a);
                                    var n = {
                                        oLanguage: { sLengthMenu: "_MENU_ records per page" },
                                        bProcessing: !0,
                                        bServerSide: !0,
                                        sAjaxSource: this.getDataUrl(this.getDataMapping()),
                                        aoColumns: t,
                                        bSort: this.isSortable(),
                                        parent: this,
                                        iDisplayLength: 15,
                                        iDisplayStart: r,
                                    };
                                    this.showActionButtons() && (n.aoColumnDefs = [{ fnRender: this.getActionButtons, aTargets: [this.getDataMapping().length] }]);
                                    var o = this.getCustomTableParams();
                                    $.extend(n, o),
                                        $("#" + e + " #grid").dataTable(n),
                                        $(".dataTables_paginate ul").addClass("pagination"),
                                        $(".dataTables_length").hide(),
                                        $(".dataTables_filter input").addClass("form-control"),
                                        $(".dataTables_filter input").attr("placeholder", "Search"),
                                        $(".dataTables_filter label")
                                            .contents()
                                            .filter(function () {
                                                return 3 === this.nodeType;
                                            })
                                            .remove(),
                                        $(".tableActionButton").tooltip();
                                },
                            },
                            { key: "getHeaders", value: function () {} },
                            { key: "getDataMapping", value: function () {} },
                            { key: "getFormFields", value: function () {} },
                            { key: "getTableData", value: function () {} },
                            {
                                key: "getFilters",
                                value: function () {
                                    return null;
                                },
                            },
                            {
                                key: "edit",
                                value: function (e) {
                                    (this.currentId = e), this.getElement(e, []);
                                },
                            },
                            {
                                key: "copyRow",
                                value: function (e) {
                                    this.getElement(e, [], !0);
                                },
                            },
                            {
                                key: "renderModel",
                                value: function (e, t, l) {
                                    $("#" + e + "ModelBody").html(""), (void 0 !== l && null != l) || (l = ""), $("#" + e + "ModelLabel").html(t), $("#" + e + "ModelBody").html(l);
                                },
                            },
                            {
                                key: "renderYesNoModel",
                                value: function (e, t, l, a, i, r) {
                                    var n = this,
                                        o = "#yesnoModel";
                                    (void 0 !== t && null != t) || (t = ""),
                                        $(o + "Label").html(e),
                                        $(o + "Body").html(t),
                                        null != l && $(o + "YesBtn").html(l),
                                        null != a && $(o + "NoBtn").html(a),
                                        $(o + "YesBtn")
                                            .off()
                                            .on("click", function () {
                                                void 0 !== i && null != i && (i.apply(n, r), n.cancelYesno());
                                            }),
                                        $(o).modal({ backdrop: "static" });
                                },
                            },
                            {
                                key: "renderModelFromDom",
                                value: function (e, t, l) {
                                    $("#" + e + "ModelBody").html(""), (void 0 !== l && null != l) || (l = $("<div></div>")), $("#" + e + "ModelLabel").html(t), $("#" + e + "ModelBody").html(""), $("#" + e + "ModelBody").append(l);
                                },
                            },
                            {
                                key: "deleteRow",
                                value: function (e) {
                                    (this.deleteParams.id = e), this.renderModel("delete", "Confirm Deletion", "Are you sure you want to delete this item ?"), $("#deleteModel").modal("show");
                                },
                            },
                            {
                                key: "showMessage",
                                value: function (e, t) {
                                    var l = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null,
                                        a = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : null,
                                        i = arguments.length > 4 && void 0 !== arguments[4] && arguments[4],
                                        r = this,
                                        n = "";
                                    (n = i ? "#plainMessageModel" : "#messageModel"),
                                        $(n).off(),
                                        i ? this.renderModel("plainMessage", e, t) : this.renderModel("message", e, t),
                                        null != l
                                            ? ($(n).modal({ show: !0 }),
                                              $(n).on("hidden.bs.modal", function () {
                                                  l.apply(r, a), $(".modal-backdrop").remove();
                                              }))
                                            : $(n).modal({ backdrop: "static" });
                                },
                            },
                            {
                                key: "showDomElement",
                                value: function (e, t, l, a, i) {
                                    var r = this,
                                        n = "";
                                    (n = i ? "#dataMessageModel" : "#messageModel"),
                                        $(n).unbind("hide"),
                                        i ? this.renderModelFromDom("dataMessage", e, t) : this.renderModelFromDom("message", e, t),
                                        null != l
                                            ? ($(n).modal({ show: !0 }),
                                              $(n).on("hidden.bs.modal", function () {
                                                  l.apply(r, a), $(".modal-backdrop").remove();
                                              }))
                                            : $(n).modal({ backdrop: "static" });
                                },
                            },
                            {
                                key: "confirmDelete",
                                value: function () {
                                    (void 0 === this.deleteParams.id && null == this.deleteParams.id) || this.deleteObj(this.deleteParams.id, []), $("#deleteModel").modal("hide");
                                },
                            },
                            {
                                key: "cancelDelete",
                                value: function () {
                                    $("#deleteModel").modal("hide"), (this.deleteParams.id = null);
                                },
                            },
                            {
                                key: "closeMessage",
                                value: function () {
                                    $("#messageModel").modal("hide");
                                },
                            },
                            {
                                key: "cancelYesno",
                                value: function () {
                                    $("#yesnoModel").modal("hide");
                                },
                            },
                            {
                                key: "closePlainMessage",
                                value: function () {
                                    $("#plainMessageModel").modal("hide"), $("#dataMessageModel").modal("hide");
                                },
                            },
                            {
                                key: "closeDataMessage",
                                value: function () {
                                    $("#dataMessageModel").modal("hide");
                                },
                            },
                            {
                                key: "save",
                                value: function (e, t) {
                                    var l = new n.default(this.getTableName() + "_submit", !0, { ShowPopup: !1, LabelErrorClass: "error" });
                                    if (l.checkValues()) {
                                        var a = l.getFormParameters();
                                        a = this.forceInjectValuesBeforeSave(a);
                                        var i = this.doCustomValidation(a);
                                        if (null == i) {
                                            this.csrfRequired && (a.csrf = $("#" + this.getTableName() + "Form").data("csrf"));
                                            var r = $("#" + this.getTableName() + "_submit #id").val();
                                            null != r && void 0 !== r && "" !== r && (a.id = r), (a = this.makeEmptyDateFieldsNull(a)), this.add(a, [], e, t);
                                        } else $("#" + this.getTableName() + "Form .label").html(i), $("#" + this.getTableName() + "Form .label").show(), this.scrollToTop();
                                    }
                                },
                            },
                            {
                                key: "makeEmptyDateFieldsNull",
                                value: function (e) {
                                    return (
                                        this.getFormFields().forEach(function (t) {
                                            ("date" !== t[1].type && "datetime" !== t[1].type) ||
                                                ("" !== e[t[0]] && "0000-00-00" !== e[t[0]] && "0000-00-00 00:00:00" !== e[t[0]]) ||
                                                ("none" === t[1].validation ? (e[t[0]] = "NULL") : delete e[t[0]]);
                                        }),
                                        e
                                    );
                                },
                            },
                            {
                                key: "forceInjectValuesBeforeSave",
                                value: function (e) {
                                    return e;
                                },
                            },
                            {
                                key: "doCustomValidation",
                                value: function (e) {
                                    return null;
                                },
                            },
                            {
                                key: "filterQuery",
                                value: function () {
                                    var e = new n.default(this.getTableName() + "_filter", !0, { ShowPopup: !1, LabelErrorClass: "error" });
                                    if (e.checkValues()) {
                                        var t = e.getFormParameters();
                                        if (this.doCustomFilterValidation(t)) {
                                            for (var l in t) t.hasOwnProperty(l) && "NULL" === t[l] && delete t[l];
                                            this.setFilter(t),
                                                (this.filtersAlreadySet = !0),
                                                $("#" + this.getTableName() + "_resetFilters").show(),
                                                (this.currentFilterString = this.getFilterString(t)),
                                                this.get([]),
                                                this.closePlainMessage();
                                        }
                                    }
                                },
                            },
                            {
                                key: "getFilterString",
                                value: function (e) {
                                    var t = "",
                                        l = void 0,
                                        a = void 0,
                                        i = void 0,
                                        r = void 0,
                                        n = void 0,
                                        o = void 0,
                                        s = this.getFilters();
                                    for (var u in (null == i && (i = []), e))
                                        if (e.hasOwnProperty(u)) {
                                            if (((n = ""), (o = null), "select" === (i = this.getMetaFieldValues(u, s)).type || "select2" === i.type)) {
                                                if (void 0 !== i["remote-source"] && null != i["remote-source"])
                                                    (l = i["remote-source"]),
                                                        "NULL" === e[u] ? (n = void 0 !== i["null-label"] && null != i["null-label"] ? i["null-label"] : "Not Selected") : (o = n = this.fieldMasterData[l[0] + "_" + l[1] + "_" + l[2]][e[u]]);
                                                else if (((a = i.source[0]), "NULL" === e[u])) n = void 0 !== i["null-label"] && null != i["null-label"] ? i["null-label"] : "Not Selected";
                                                else
                                                    for (var c = 0; c < a.length; c++)
                                                        if (e[u] === i.source[c][0]) {
                                                            o = n = i.source[c][1];
                                                            break;
                                                        }
                                            } else if ("select2multi" === i.type) {
                                                r = [];
                                                try {
                                                    r = JSON.parse(e[u]);
                                                } catch (e) {}
                                                "" !== (n = r.join(",")) && (o = n);
                                            } else "" !== (n = e[u]) && (o = n);
                                            null != o && ("" !== t && (t += " | "), (t += i.label + " = " + n));
                                        }
                                    return t;
                                },
                            },
                            {
                                key: "doCustomFilterValidation",
                                value: function (e) {
                                    return !0;
                                },
                            },
                            {
                                key: "resetFilters",
                                value: function () {
                                    (this.filter = this.origFilter), (this.filtersAlreadySet = !1), $("#" + this.getTableName() + "_resetFilters").hide(), (this.currentFilterString = ""), this.get([]);
                                },
                            },
                            {
                                key: "showFilters",
                                value: function (e) {
                                    for (var t = this.templates.filterTemplate, l = "", a = this.getFilters(), i = 0; i < a.length; i++) {
                                        var r = this.getMetaFieldForRendering(a[i][0]);
                                        if ("" === r || void 0 === r) l += this.renderFormField(a[i]);
                                        else {
                                            var n = e[r];
                                            "" !== n && null != n && void 0 !== n && "" !== n.trim() ? (l += this.renderFormField(JSON.parse(n))) : (l += this.renderFormField(a[i]));
                                        }
                                    }
                                    t = (t = t.replace(/_id_/g, this.getTableName() + "_filter")).replace(/_fields_/g, l);
                                    var o = this.generateRandom(14),
                                        s = $('<div class="reviewBlock popupForm" data-content="Form"></div>');
                                    s.attr("id", o),
                                        s.html(t),
                                        s.find(".datefield").datepicker({ viewMode: 2 }),
                                        s.find(".timefield").datetimepicker({ language: "en", pickDate: !1 }),
                                        s.find(".datetimefield").datetimepicker({ language: "en" }),
                                        s.find(".colorpick").colorpicker(),
                                        tinymce.init({ selector: "#" + s.attr("id") + " .tinymce", height: "400" }),
                                        s.find(".simplemde").each(function () {
                                            var e = new SimpleMDE({ element: $(this)[0] });
                                            $(this).data("simplemde", e);
                                        }),
                                        s.find(".select2Field").each(function () {
                                            $(this).select2().select2("val", $(this).find("option:eq(0)").val());
                                        }),
                                        s.find(".select2Multi").each(function () {
                                            $(this)
                                                .select2()
                                                .on("change", function (e) {
                                                    var t = $(this).parents(".row"),
                                                        l = t.find(".select2-choices").height();
                                                    t.height(parseInt(l, 10));
                                                });
                                        }),
                                        this.showDomElement("Edit", s, null, null, !0),
                                        $(".filterBtn").off(),
                                        $(".filterBtn").on("click", function (e) {
                                            e.preventDefault(), e.stopPropagation();
                                            try {
                                                modJs.filterQuery();
                                            } catch (e) {}
                                            return !1;
                                        }),
                                        void 0 !== this.filter && null != this.filter && "" !== this.filter && this.fillForm(this.filter, "#" + this.getTableName() + "_filter", this.getFilters());
                                },
                            },
                            { key: "preRenderForm", value: function (e) {} },
                            {
                                key: "renderForm",
                                value: function (e) {
                                    var t = [];
                                    (null != e && void 0 !== e) || (this.currentId = null), this.preRenderForm(e);
                                    for (var l = this.templates.formTemplate, a = "", i = this.getFormFields(), r = 0; r < i.length; r++) {
                                        var n = this.getMetaFieldForRendering(i[r][0]);
                                        if ("" === n || void 0 === n) a += this.renderFormField(i[r]);
                                        else {
                                            var o = e[n];
                                            "" !== o && null != o && void 0 !== o && "" !== o.trim() ? (a += this.renderFormField(JSON.parse(o))) : (a += this.renderFormField(i[r]));
                                        }
                                    }
                                    l = (l = l.replace(/_id_/g, this.getTableName() + "_submit")).replace(/_fields_/g, a);
                                    var s = void 0,
                                        u = this.generateRandom(14);
                                    this.showFormOnPopup ? (s = $('<div class="reviewBlock popupForm" data-content="Form"></div>')).attr("id", u) : (s = $("#" + this.getTableName() + "Form")),
                                        s.html(l),
                                        s.find(".datefield").datepicker({ viewMode: 2 }),
                                        s.find(".timefield").datetimepicker({ language: "en", pickDate: !1 }),
                                        s.find(".datetimefield").datetimepicker({ language: "en" }),
                                        s.find(".colorpick").colorpicker(),
                                        tinymce.init({ selector: "#" + s.attr("id") + " .tinymce", height: "400" }),
                                        s.find(".simplemde").each(function () {
                                            var e = new SimpleMDE({ element: $(this)[0] });
                                            $(this).data("simplemde", e);
                                        }),
                                        s.find(".select2Field").each(function () {
                                            $(this).select2().select2("val", $(this).find("option:eq(0)").val());
                                        }),
                                        s.find(".select2Multi").each(function () {
                                            $(this)
                                                .select2()
                                                .on("change", function (e) {
                                                    var t = $(this).parents(".row"),
                                                        l = t.find(".select2-choices").height();
                                                    t.height(parseInt(l, 10));
                                                });
                                        }),
                                        s.find(".signatureField").each(function () {
                                            t.push($(this).attr("id"));
                                        });
                                    for (var c = 0; c < i.length; c++) "datagroup" === i[c][1].type && s.find("#" + i[c][0]).data("field", i[c]);
                                    if (
                                        (!1 === this.showSave
                                            ? s.find(".saveBtn").remove()
                                            : (s.find(".saveBtn").off(),
                                              s.find(".saveBtn").data("modJs", this),
                                              s.find(".saveBtn").on("click", function () {
                                                  return (
                                                      null != $(this).data("modJs").saveSuccessItemCallback && void 0 !== $(this).data("modJs").saveSuccessItemCallback
                                                          ? $(this).data("modJs").save($(this).data("modJs").retriveItemsAfterSave(), $(this).data("modJs").saveSuccessItemCallback)
                                                          : $(this).data("modJs").save(),
                                                      !1
                                                  );
                                              })),
                                        !1 === this.showCancel
                                            ? s.find(".cancelBtn").remove()
                                            : (s.find(".cancelBtn").off(),
                                              s.find(".cancelBtn").data("modJs", this),
                                              s.find(".cancelBtn").on("click", function () {
                                                  return $(this).data("modJs").cancel(), !1;
                                              })),
                                        s.find("[mask]").each(function () {
                                            $(this).inputmask($(this).attr("mask"));
                                        }),
                                        s.find("[datemask]").each(function () {
                                            $(this).inputmask({ mask: "y-1-2", placeholder: "YYYY-MM-DD", leapday: "-02-29", separator: "-", alias: "yyyy/mm/dd" });
                                        }),
                                        s.find("[datetimemask]").each(function () {
                                            $(this).inputmask("datetime", { mask: "y-2-1 h:s:00", placeholder: "YYYY-MM-DD hh:mm:ss", leapday: "-02-29", separator: "-", alias: "yyyy/mm/dd" });
                                        }),
                                        this.showFormOnPopup)
                                    ) {
                                        this.showMessage("Edit", "", null, null, !0), $("#plainMessageModel .modal-body").html(""), $("#plainMessageModel .modal-body").append(s);
                                        for (var d = 0; d < t.length; d++) $("#" + t[d]).data("signaturePad", new SignaturePad(document.getElementById(t[d])));
                                        void 0 !== e && null != e ? this.fillForm(e, "#" + u) : this.setDefaultValues("#" + u);
                                    } else {
                                        $("#" + this.getTableName() + "Form").show(), $("#" + this.getTableName()).hide();
                                        for (var h = 0; h < t.length; h++) $("#" + t[h]).data("signaturePad", new SignaturePad(document.getElementById(t[h])));
                                        void 0 !== e && null != e ? this.fillForm(e) : this.setDefaultValues(), this.scrollToTop();
                                    }
                                    this.postRenderForm(e, s);
                                },
                            },
                            {
                                key: "setDefaultValues",
                                value: function (e, t) {
                                    (null != t && void 0 !== t) || (t = this.getFormFields()), (null != e && void 0 !== e && "" !== e) || (e = "#" + this.getTableName() + "Form");
                                    for (var l = 0; l < t.length; l++) ("text" !== t[l][1].type && "textarea" !== t[l][1].type) || (void 0 !== t[l][1].default && null !== t[l][1].default && $(e + " #" + t[l][0]).val(t[l][1].default));
                                },
                            },
                            {
                                key: "retriveItemsAfterSave",
                                value: function () {
                                    return !0;
                                },
                            },
                            { key: "postRenderForm", value: function (e, t) {} },
                            {
                                key: "dataGroupToHtml",
                                value: function (e, t) {
                                    var l = JSON.parse(e),
                                        a = void 0,
                                        i = void 0,
                                        r = void 0,
                                        n = void 0,
                                        o = t[1].html;
                                    null != l && void 0 !== l && void 0 !== t[1]["sort-function"] && null != t[1]["sort-function"] && l.sort(t[1]["sort-function"]);
                                    for (var s = $('<div id="' + t[0] + '_div_inner"></div>'), u = 0; u < l.length; u++) {
                                        for (var c in ((i = l[u]),
                                        void 0 !== t[1]["pre-format-function"] && null != t[1]["pre-format-function"] && (i = t[1]["pre-format-function"].apply(this, [i])),
                                        (a = (a = (a = (a = o).replace(
                                            "#_delete_#",
                                            '<a id="#_id_#_delete" onclick="modJs.deleteDataGroupItem(\'#_id_#\');return false;" type="button" style="float:right;margin-right:3px;" tooltip="Delete"><li class="fa fa-times"></li></a>'
                                        )).replace(
                                            "#_edit_#",
                                            '<a id="#_id_#_edit" onclick="modJs.editDataGroupItem(\'#_id_#\');return false;" type="button" style="float:right;margin-right:5px;" tooltip="Edit"><li class="fa fa-edit"></li></a>'
                                        )).replace(/#_id_#/g, i.id)),
                                        i))
                                            void 0 !== (n = i[c]) && null != n && "string" == typeof n && (n = n.replace(/(?:\r\n|\r|\n)/g, "<br />")), (a = a.replace("#_" + c + "_#", n));
                                        void 0 !== t[1].render && null != t[1].render && (a = a.replace("#_renderFunction_#", t[1].render(i))), (r = $(a)).attr("fieldId", t[0] + "_div"), s.append(r);
                                    }
                                    return s;
                                },
                            },
                            {
                                key: "resetDataGroup",
                                value: function (e) {
                                    $("#" + e[0]).val(""), $("#" + e[0] + "_div").html("");
                                },
                            },
                            {
                                key: "showDataGroup",
                                value: function (e, t) {
                                    var l = this.templates.datagroupTemplate,
                                        a = "",
                                        i = e[1].form;
                                    void 0 !== t && null != t && void 0 !== t.id ? (this.currentDataGroupItemId = t.id) : (this.currentDataGroupItemId = null);
                                    for (var r = 0; r < i.length; r++) a += this.renderFormField(i[r]);
                                    l = (l = l.replace(/_id_/g, this.getTableName() + "_field_" + e[0])).replace(/_fields_/g, a);
                                    var n = this.generateRandom(14),
                                        o = $('<div class="reviewBlock popupForm" data-content="Form"></div>');
                                    o.attr("id", n),
                                        o.html(l),
                                        o.find(".datefield").datepicker({ viewMode: 2 }),
                                        o.find(".timefield").datetimepicker({ language: "en", pickDate: !1 }),
                                        o.find(".datetimefield").datetimepicker({ language: "en" }),
                                        o.find(".colorpick").colorpicker(),
                                        tinymce.init({ selector: "#" + o.attr("id") + " .tinymce", height: "400" }),
                                        o.find(".simplemde").each(function () {
                                            var e = new SimpleMDE({ element: $(this)[0] });
                                            $(this).data("simplemde", e);
                                        }),
                                        o.find(".select2Field").each(function () {
                                            $(this).select2().select2("val", $(this).find("option:eq(0)").val());
                                        }),
                                        o.find(".select2Multi").each(function () {
                                            $(this)
                                                .select2()
                                                .on("change", function (e) {
                                                    var t = $(this).parents(".row"),
                                                        l = t.find(".select2-choices").height();
                                                    t.height(parseInt(l, 10));
                                                });
                                        }),
                                        (this.currentDataGroupField = e),
                                        this.showDomElement("Add " + e[1].label, o, null, null, !0),
                                        void 0 !== t && null != t ? this.fillForm(t, "#" + this.getTableName() + "_field_" + e[0], e[1].form) : this.setDefaultValues("#" + this.getTableName() + "_field_" + e[0], e[1].form),
                                        $(".groupAddBtn").off(),
                                        void 0 !== t && null != t && void 0 !== t.id
                                            ? $(".groupAddBtn").on("click", function (e) {
                                                  e.preventDefault(), e.stopPropagation();
                                                  try {
                                                      modJs.editDataGroup();
                                                  } catch (e) {
                                                      console.log("Error editing data group: " + e.message);
                                                  }
                                                  return !1;
                                              })
                                            : $(".groupAddBtn").on("click", function (e) {
                                                  e.preventDefault(), e.stopPropagation();
                                                  try {
                                                      modJs.addDataGroup();
                                                  } catch (e) {
                                                      console.log("Error adding data group: " + e.message);
                                                  }
                                                  return !1;
                                              });
                                },
                            },
                            {
                                key: "addDataGroup",
                                value: function () {
                                    var e = this.currentDataGroupField,
                                        t = void 0;
                                    $("#" + this.getTableName() + "_field_" + e[0] + "_error").html(""), $("#" + this.getTableName() + "_field_" + e[0] + "_error").hide();
                                    var l = new n.default(this.getTableName() + "_field_" + e[0], !0, { ShowPopup: !1, LabelErrorClass: "error" });
                                    if (l.checkValues()) {
                                        var a = l.getFormParameters();
                                        if (void 0 !== e[1]["custom-validate-function"] && null != e[1]["custom-validate-function"]) {
                                            if (!(t = e[1]["custom-validate-function"].apply(this, [a])).valid)
                                                return $("#" + this.getTableName() + "_field_" + e[0] + "_error").html(t.message), $("#" + this.getTableName() + "_field_" + e[0] + "_error").show(), !1;
                                            a = t.params;
                                        }
                                        var i = $("#" + e[0]).val();
                                        "" === i && (i = "[]");
                                        var r = JSON.parse(i);
                                        (a.id = e[0] + "_" + this.dataGroupGetNextAutoIncrementId(r)), r.push(a), void 0 !== e[1]["sort-function"] && null != e[1]["sort-function"] && r.sort(e[1]["sort-function"]), (i = JSON.stringify(r));
                                        var o = this.dataGroupToHtml(i, e);
                                        $("#" + e[0] + "_div").html(""),
                                            $("#" + e[0] + "_div").append(o),
                                            this.makeDataGroupSortable(e, $("#" + e[0] + "_div_inner")),
                                            $("#" + e[0]).val(i),
                                            this.orderDataGroup(e),
                                            this.closeDataMessage(),
                                            this.showMessage("Item Added", "This change will be effective only when you save the form");
                                    }
                                    return !0;
                                },
                            },
                            {
                                key: "nl2br",
                                value: function (e, t) {
                                    var l = "";
                                    try {
                                        for (var a = e.split(" "), i = 0, r = 0; r < a.length; r++) (i += a[r].length + 1) > t ? ((l += a[r] + "<br/>"), (i = 0)) : (l += a[r] + " ");
                                    } catch (e) {}
                                    return l;
                                },
                            },
                            {
                                key: "makeDataGroupSortable",
                                value: function (e, t) {
                                    t.data("field", e),
                                        t.data("firstSort", !0),
                                        t.sortable({
                                            create: function () {
                                                $(this).height($(this).height());
                                            },
                                            "ui-floating": !1,
                                            start: function (e, t) {
                                                $("#sortable-ul-selector-id").sortable({
                                                    sort: function (e, t) {
                                                        var l = $(e.target);
                                                        if (!/html|body/i.test(l.offsetParent()[0].tagName)) {
                                                            var a = e.pageY - l.offsetParent().offset().top - t.helper.outerHeight(!0) / 2;
                                                            t.helper.css({ top: a + "px" });
                                                        }
                                                    },
                                                });
                                            },
                                            revert: !0,
                                            stop: function () {
                                                modJs.orderDataGroup($(this).data("field"));
                                            },
                                            axis: "y",
                                            scroll: !1,
                                            placeholder: "sortable-placeholder",
                                            cursor: "move",
                                        });
                                },
                            },
                            {
                                key: "orderDataGroup",
                                value: function (e) {
                                    var t = [],
                                        l = void 0,
                                        a = $("#" + e[0] + "_div_inner [fieldid='" + e[0] + "_div']"),
                                        i = $("#" + e[0]).val();
                                    "" === i && (i = "[]");
                                    var r = JSON.parse(i);
                                    a.each(function () {
                                        for (var e in ((l = $(this).attr("id")), r))
                                            if (r[e].id === l) {
                                                t.push(r[e]);
                                                break;
                                            }
                                    }),
                                        $("#" + e[0]).val(JSON.stringify(t));
                                },
                            },
                            {
                                key: "editDataGroup",
                                value: function () {
                                    var e = this.currentDataGroupField,
                                        t = this.currentDataGroupItemId,
                                        l = new n.default(this.getTableName() + "_field_" + e[0], !0, { ShowPopup: !1, LabelErrorClass: "error" });
                                    if (l.checkValues()) {
                                        var a = l.getFormParameters();
                                        if (void 0 !== e[1]["custom-validate-function"] && null != e[1]["custom-validate-function"]) {
                                            var i = e[1]["custom-validate-function"].apply(this, [a]);
                                            if (!i.valid) return $("#" + this.getTableName() + "_field_" + e[0] + "_error").html(i.message), $("#" + this.getTableName() + "_field_" + e[0] + "_error").show(), !1;
                                            a = i.params;
                                        }
                                        if (this.doCustomFilterValidation(a)) {
                                            var r = $("#" + e[0]).val();
                                            "" === r && (r = "[]");
                                            for (var o = JSON.parse(r), s = {}, u = -1, c = [], d = 0; d < o.length; d++) {
                                                var h = o[d];
                                                h.id === t && ((s = h), (u = d)), c.push(h);
                                            }
                                            (a.id = s.id), (c[u] = a), void 0 !== e[1]["sort-function"] && null != e[1]["sort-function"] && c.sort(e[1]["sort-function"]), (r = JSON.stringify(c)), $("#" + e[0]).val(r);
                                            var f = this.dataGroupToHtml(r, e);
                                            this.orderDataGroup(e),
                                                $("#" + e[0] + "_div").html(""),
                                                $("#" + e[0] + "_div").append(f),
                                                this.makeDataGroupSortable(e, $("#" + e[0] + "_div_inner")),
                                                this.closeDataMessage(),
                                                this.showMessage("Item Edited", "This change will be effective only when you save the form");
                                        }
                                    }
                                    return !0;
                                },
                            },
                            {
                                key: "editDataGroupItem",
                                value: function (e) {
                                    for (var t = e.substring(0, e.lastIndexOf("_")), l = $("#" + t).val(), a = JSON.parse(l), i = {}, r = 0; r < a.length; r++) {
                                        var n = a[r];
                                        n.id === e && (i = n);
                                    }
                                    this.showDataGroup($("#" + t).data("field"), i);
                                },
                            },
                            {
                                key: "dataGroupGetNextAutoIncrementId",
                                value: function (e) {
                                    for (var t = 1, l = void 0, a = 0; a < e.length; a++) {
                                        var i = e[a];
                                        (void 0 !== i.id && null != i.id) || (i.id = 1), (l = i.id.substring(i.id.lastIndexOf("_") + 1, i.id.length)) >= t && (t = parseInt(l, 10) + 1);
                                    }
                                    return t;
                                },
                            },
                            {
                                key: "deleteDataGroupItem",
                                value: function (e) {
                                    for (var t = e.substring(0, e.lastIndexOf("_")), l = $("#" + t).val(), a = JSON.parse(l), i = [], r = 0; r < a.length; r++) {
                                        var n = a[r];
                                        n.id !== e && i.push(n);
                                    }
                                    $("#" + t).val(JSON.stringify(i)), $("#" + e).remove(), this.showMessage("Item Removed", "Item removed. This change will be effective only when you save the form");
                                },
                            },
                            {
                                key: "fillForm",
                                value: function (e, t, l) {
                                    var a = void 0;
                                    (null != l && void 0 !== l) || (l = this.getFormFields()), (null != t && void 0 !== t && "" !== t) || (t = "#" + this.getTableName() + "Form");
                                    for (var i = 0; i < l.length; i++)
                                        if ("date" === l[i][1].type) "0000-00-00" !== e[l[i][0]] && "" !== e[l[i][0]] && null != e[l[i][0]] && void 0 !== e[l[i][0]] && $(t + " #" + l[i][0] + "_date").datepicker("setValue", e[l[i][0]]);
                                        else if ("colorpick" === l[i][1].type) null != e[l[i][0]] && void 0 !== e[l[i][0]] && ($(t + " #" + l[i][0] + "_colorpick").colorpicker("setValue", e[l[i][0]]), $(t + " #" + l[i][0]).val(e[l[i][0]]));
                                        else if ("datetime" === l[i][1].type || "time" === l[i][1].type) {
                                            if ("0000-00-00 00:00:00" !== e[l[i][0]] && "" !== e[l[i][0]] && null != e[l[i][0]] && void 0 !== e[l[i][0]]) {
                                                var r = e[l[i][0]].split(" "),
                                                    n = r[0].split("-"),
                                                    o = r[1].split(":");
                                                $(t + " #" + l[i][0] + "_datetime")
                                                    .data("datetimepicker")
                                                    .setLocalDate(new Date(n[0], parseInt(n[1], 10) - 1, n[2], o[0], o[1], o[2]));
                                            }
                                        } else if ("label" === l[i][1].type) $(t + " #" + l[i][0]).html(e[l[i][0]]);
                                        else if ("placeholder" === l[i][1].type) {
                                            if (void 0 !== l[i][1]["remote-source"] && null != l[i][1]["remote-source"]) {
                                                var s = l[i][1]["remote-source"][0] + "_" + l[i][1]["remote-source"][1] + "_" + l[i][1]["remote-source"][2];
                                                a = this.fieldMasterData[s][e[l[i][0]]];
                                            } else a = e[l[i][0]];
                                            if (void 0 === a || null == a) a = "";
                                            else
                                                try {
                                                    a = a.replace(/(?:\r\n|\r|\n)/g, "<br />");
                                                } catch (e) {}
                                            if (void 0 !== l[i][1].formatter && l[i][1].formatter && $.isFunction(l[i][1].formatter))
                                                try {
                                                    a = l[i][1].formatter(a);
                                                } catch (e) {}
                                            $(t + " #" + l[i][0]).html(a);
                                        } else if ("fileupload" === l[i][1].type)
                                            null != e[l[i][0]] &&
                                                void 0 !== e[l[i][0]] &&
                                                "" !== e[l[i][0]] &&
                                                ($(t + " #" + l[i][0]).html(e[l[i][0]]),
                                                $(t + " #" + l[i][0]).attr("val", e[l[i][0]]),
                                                $(t + " #" + l[i][0]).show(),
                                                $(t + " #" + l[i][0] + "_download").show(),
                                                $(t + " #" + l[i][0] + "_remove").show()),
                                                !0 === l[i][1].readonly && $(t + " #" + l[i][0] + "_upload").remove();
                                        else if ("select" === l[i][1].type) (void 0 !== e[l[i][0]] && null != e[l[i][0]] && "" !== e[l[i][0]]) || (e[l[i][0]] = "NULL"), $(t + " #" + l[i][0]).val(e[l[i][0]]);
                                        else if ("select2" === l[i][1].type) (void 0 !== e[l[i][0]] && null != e[l[i][0]] && "" !== e[l[i][0]]) || (e[l[i][0]] = "NULL"), $(t + " #" + l[i][0]).select2("val", e[l[i][0]]);
                                        else if ("select2multi" === l[i][1].type) {
                                            (void 0 !== e[l[i][0]] && null != e[l[i][0]] && "" !== e[l[i][0]]) || (e[l[i][0]] = "NULL");
                                            var u = [];
                                            if (void 0 !== e[l[i][0]] && null != e[l[i][0]] && "" !== e[l[i][0]])
                                                try {
                                                    u = JSON.parse(e[l[i][0]]);
                                                } catch (e) {}
                                            $(t + " #" + l[i][0]).select2("val", u);
                                            var c = $(t + " #" + l[i][0])
                                                .find(".select2-choices")
                                                .height();
                                            $(t + " #" + l[i][0])
                                                .find(".controls")
                                                .css("min-height", c + "px"),
                                                $(t + " #" + l[i][0]).css("min-height", c + "px");
                                        } else if ("datagroup" === l[i][1].type)
                                            try {
                                                var d = this.dataGroupToHtml(e[l[i][0]], l[i]);
                                                $(t + " #" + l[i][0]).val(e[l[i][0]]),
                                                    $(t + " #" + l[i][0] + "_div").html(""),
                                                    $(t + " #" + l[i][0] + "_div").append(d),
                                                    this.makeDataGroupSortable(l[i], $(t + " #" + l[i][0] + "_div_inner"));
                                            } catch (e) {}
                                        else
                                            "signature" === l[i][1].type
                                                ? ("" === e[l[i][0]] && void 0 === e[l[i][0]] && null == e[l[i][0]]) ||
                                                  $(t + " #" + l[i][0])
                                                      .data("signaturePad")
                                                      .fromDataURL(e[l[i][0]])
                                                : "simplemde" === l[i][1].type
                                                ? $(t + " #" + l[i][0])
                                                      .data("simplemde")
                                                      .value(e[l[i][0]])
                                                : $(t + " #" + l[i][0]).val(e[l[i][0]]);
                                },
                            },
                            {
                                key: "cancel",
                                value: function () {
                                    $("#" + this.getTableName() + "Form").hide(), $("#" + this.getTableName()).show();
                                },
                            },
                            {
                                key: "renderFormField",
                                value: function (e) {
                                    var t = 0;
                                    if (void 0 === this.fieldTemplates[e[1].type] || null == this.fieldTemplates[e[1].type]) return "";
                                    var l = this.fieldTemplates[e[1].type];
                                    if (
                                        ((e[1].label = this.gt(e[1].label)),
                                        "none" !== e[1].validation && "emailOrEmpty" !== e[1].validation && "numberOrEmpty" !== e[1].validation && "placeholder" !== e[1].type && e[1].label.indexOf("*") < 0)
                                    ) {
                                        (["select", "select2"].indexOf(e[1].type) >= 0 && !0 === e[1]["allow-null"]) || (e[1].label = e[1].label + '<font class="redFont">*</font>');
                                    }
                                    if ("text" === e[1].type || "textarea" === e[1].type || "hidden" === e[1].type || "label" === e[1].type || "placeholder" === e[1].type) l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
                                    else if ("select" === e[1].type || "select2" === e[1].type || "select2multi" === e[1].type) {
                                        if (((l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label)), void 0 !== e[1].source && null != e[1].source)) l = l.replace("_options_", this.renderFormSelectOptions(e[1].source, e));
                                        else if (void 0 !== e[1]["remote-source"] && null != e[1]["remote-source"]) {
                                            var a = e[1]["remote-source"][0] + "_" + e[1]["remote-source"][1] + "_" + e[1]["remote-source"][2];
                                            l = l.replace("_options_", this.renderFormSelectOptionsRemote(this.fieldMasterData[a], e));
                                        }
                                    } else if ("colorpick" === e[1].type) l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
                                    else if ("date" === e[1].type) l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
                                    else if ("datetime" === e[1].type) l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
                                    else if ("time" === e[1].type) l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
                                    else if ("fileupload" === e[1].type) {
                                        l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label);
                                        var i = this.getCurrentProfile();
                                        (t = null != i && void 0 !== i ? i.id : -1 * this.getUser().id),
                                            (l = (l = l.replace(/_userId_/g, t)).replace(/_group_/g, this.tab)),
                                            (l = (l = void 0 !== e[1].filetypes && null != e[1].filetypes ? l.replace(/_filetypes_/g, e[1].filetypes) : l.replace(/_filetypes_/g, "all")).replace(/_rand_/g, this.generateRandom(14)));
                                    } else
                                        "datagroup" === e[1].type
                                            ? (l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label))
                                            : "signature" === e[1].type
                                            ? (l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label))
                                            : ("tinymce" !== e[1].type && "simplemde" !== e[1].type) || (l = (l = l.replace(/_id_/g, e[0])).replace(/_label_/g, e[1].label));
                                    return (
                                        (l = void 0 !== e[1].validation && null != e[1].validation && "" !== e[1].validation ? l.replace(/_validation_/g, 'validation="' + e[1].validation + '"') : l.replace(/_validation_/g, "")),
                                        (l =
                                            void 0 !== e[1].help && null !== e[1].help
                                                ? (l = l.replace(/_helpline_/g, e[1].help)).replace(/_hidden_class_help_/g, "")
                                                : (l = l.replace(/_helpline_/g, "")).replace(/_hidden_class_help_/g, "hide")),
                                        (l = void 0 !== e[1].placeholder && null !== e[1].placeholder ? l.replace(/_placeholder_/g, 'placeholder="' + e[1].placeholder + '"') : l.replace(/_placeholder_/g, "")),
                                        (l = void 0 !== e[1].mask && null !== e[1].mask ? l.replace(/_mask_/g, 'mask="' + e[1].mask + '"') : l.replace(/_mask_/g, ""))
                                    );
                                },
                            },
                            {
                                key: "renderFormSelectOptions",
                                value: function (e, t) {
                                    var l = "";
                                    null != t &&
                                        void 0 !== t &&
                                        !0 === t[1]["allow-null"] &&
                                        (void 0 !== t[1]["null-label"] && null != t[1]["null-label"] ? (l += '<option value="NULL">' + this.gt(t[1]["null-label"]) + "</option>") : (l += '<option value="NULL">Select</option>'));
                                    var a = [];
                                    for (var i in e) a.push(e[i]);
                                    !0 === t[1].sort &&
                                        a.sort(function (e, t) {
                                            return (e = e[1]) < (t = t[1]) ? -1 : e > t ? 1 : 0;
                                        });
                                    for (var r = 0; r < a.length; r++) {
                                        var n = a[r][0],
                                            o = a[r][1],
                                            s = '<option value="_id_">_val_</option>';
                                        l += s = (s = s.replace("_id_", n)).replace("_val_", this.gt(o));
                                    }
                                    return l;
                                },
                            },
                            {
                                key: "renderFormSelectOptionsRemote",
                                value: function (e, t) {
                                    var l = "";
                                    !0 === t[1]["allow-null"] &&
                                        (void 0 !== t[1]["null-label"] && null != t[1]["null-label"] ? (l += '<option value="NULL">' + this.gt(t[1]["null-label"]) + "</option>") : (l += '<option value="NULL">Select</option>'));
                                    var a = [];
                                    for (var i in e) a.push([i, e[i]]);
                                    "true" === t[1].sort &&
                                        a.sort(function (e, t) {
                                            return (e = e[1]) < (t = t[1]) ? -1 : e > t ? 1 : 0;
                                        });
                                    for (var r = 0; r < a.length; r++) {
                                        var n = a[r][0],
                                            o = a[r][1],
                                            s = '<option value="_id_">_val_</option>';
                                        l += s = (s = s.replace("_id_", n)).replace("_val_", this.gt(o));
                                    }
                                    return l;
                                },
                            },
                            {
                                key: "setCustomTemplates",
                                value: function (e) {
                                    this.customTemplates = e;
                                },
                            },
                            {
                                key: "setEmailTemplates",
                                value: function (e) {
                                    this.emailTemplates = e;
                                },
                            },
                            {
                                key: "getCustomTemplate",
                                value: function (e) {
                                    return this.customTemplates[e];
                                },
                            },
                            {
                                key: "setFieldTemplates",
                                value: function (e) {
                                    this.fieldTemplates = e;
                                },
                            },
                            {
                                key: "getMetaFieldForRendering",
                                value: function (e) {
                                    return "";
                                },
                            },
                            {
                                key: "clearDeleteParams",
                                value: function () {
                                    this.deleteParams = {};
                                },
                            },
                            {
                                key: "getShowAddNew",
                                value: function () {
                                    return this.showAddNew;
                                },
                            },
                            {
                                key: "getAddNewLabel",
                                value: function () {
                                    return "Add New";
                                },
                            },
                            {
                                key: "setShowAddNew",
                                value: function (e) {
                                    this.showAddNew = e;
                                },
                            },
                            {
                                key: "setShowDelete",
                                value: function (e) {
                                    this.showDelete = e;
                                },
                            },
                            {
                                key: "setShowEdit",
                                value: function (e) {
                                    this.showEdit = e;
                                },
                            },
                            {
                                key: "setShowSave",
                                value: function (e) {
                                    this.showSave = e;
                                },
                            },
                            {
                                key: "setShowCancel",
                                value: function (e) {
                                    this.showCancel = e;
                                },
                            },
                            {
                                key: "getCustomTableParams",
                                value: function () {
                                    return {};
                                },
                            },
                            {
                                key: "getActionButtons",
                                value: function (e) {
                                    return modJs.getActionButtonsHtml(e.aData[0], e.aData);
                                },
                            },
                            {
                                key: "getActionButtonsHtml",
                                value: function (e, t) {
                                    var l = '<div style="width:80px;">_edit__delete__clone_</div>';
                                    return (
                                        (l = this.showAddNew
                                            ? l.replace(
                                                  "_clone_",
                                                  '<img class="tableActionButton" src="_BASE_images/clone.png" style="margin-left:15px;cursor:pointer;" rel="tooltip" title="Copy" onclick="modJs.copyRow(_id_);return false;"></img>'
                                              )
                                            : l.replace("_clone_", "")),
                                        (l = this.showDelete
                                            ? l.replace(
                                                  "_delete_",
                                                  '<img class="tableActionButton" src="_BASE_images/delete.png" style="margin-left:15px;cursor:pointer;" rel="tooltip" title="Delete" onclick="modJs.deleteRow(_id_);return false;"></img>'
                                              )
                                            : l.replace("_delete_", "")),
                                        (l = (l = (l = this.showEdit
                                            ? l.replace("_edit_", '<img class="tableActionButton" src="_BASE_images/edit.png" style="cursor:pointer;" rel="tooltip" title="Edit" onclick="modJs.edit(_id_);return false;"></img>')
                                            : l.replace("_edit_", "")).replace(/_id_/g, e)).replace(/_BASE_/g, this.baseUrl))
                                    );
                                },
                            },
                            {
                                key: "generateRandom",
                                value: function (e) {
                                    for (var t = new Date(), l = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", a = "", i = e; i > 0; --i) a += l[Math.round(Math.random() * (l.length - 1))];
                                    return a + t.getTime();
                                },
                            },
                            {
                                key: "checkFileType",
                                value: function (e, t) {
                                    var l = document.getElementById(e),
                                        a = "";
                                    return (
                                        l.value.lastIndexOf(".") > 0 && (a = l.value.substring(l.value.lastIndexOf(".") + 1, l.value.length)),
                                        (a = a.toLowerCase()),
                                        !(t.split(",").indexOf(a) < 0) || ((l.value = ""), this.showMessage("File Type Error", "Selected file type is not supported"), this.clearFileElement(e), !1)
                                    );
                                },
                            },
                            {
                                key: "clearFileElement",
                                value: function (e) {
                                    var t = $("#" + e);
                                    t.replaceWith((t = t.val("").clone(!0)));
                                },
                            },
                            {
                                key: "fixJSON",
                                value: function (e) {
                                    return "1" === this.noJSONRequests && (e = window.btoa(e)), e;
                                },
                            },
                            {
                                key: "getClientDate",
                                value: function (e) {
                                    var t = this.getClientGMTOffset();
                                    return e.addMinutes(60 * t);
                                },
                            },
                            {
                                key: "getClientGMTOffset",
                                value: function () {
                                    var e = new Date(),
                                        t = new Date(e.getFullYear(), 0, 1, 0, 0, 0, 0),
                                        l = t.toGMTString();
                                    return (t - new Date(l.substring(0, l.lastIndexOf(" ") - 1))) / 36e5;
                                },
                            },
                            {
                                key: "getHelpLink",
                                value: function () {
                                    return null;
                                },
                            },
                            {
                                key: "showLoader",
                                value: function () {
                                    $("#iceloader").show();
                                },
                            },
                            {
                                key: "hideLoader",
                                value: function () {
                                    $("#iceloader").hide();
                                },
                            },
                            {
                                key: "generateOptions",
                                value: function (e) {
                                    var t = "";
                                    for (var l in e) t += '<option value="__val__">__text__</option>'.replace("__val__", l).replace("__text__", e[l]);
                                    return t;
                                },
                            },
                            {
                                key: "isModuleInstalled",
                                value: function (e, t) {
                                    return void 0 !== modulesInstalled && null !== modulesInstalled && 1 === modulesInstalled[e + "_" + t];
                                },
                            },
                            {
                                key: "setCustomFields",
                                value: function (e) {
                                    for (var t = void 0, l = void 0, a = 0; a < e.length; a++)
                                        if ("Hidden" !== (t = e[a]).display && "" !== t.data && void 0 !== t.data)
                                            try {
                                                if (void 0 === (l = JSON.parse(t.data)) || null == l) continue;
                                                if (2 !== l.length) continue;
                                                if (void 0 === l[1].type || null == l[1].type) continue;
                                                this.customFields.push(l);
                                            } catch (e) {}
                                },
                            },
                            {
                                key: "addCustomFields",
                                value: function (e) {
                                    for (var t = 0; t < this.customFields.length; t++) e.push(this.customFields[t]);
                                    return e;
                                },
                            },
                        ]),
                        e
                    );
                })();
                l.default = o;
            },
            { "./FormValidation": 5 },
        ],
    },
    {},
    [1]
);
//# sourceMappingURL=jobpositions.js.map
