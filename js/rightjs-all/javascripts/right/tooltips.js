/**
 * RightJS-UI Tooltips v2.2.1
 * http://rightjs.org/ui/tooltips
 *
 * Copyright (C) 2009-2011 Nikolay Nemshilov
 */
var Tooltip = RightJS.Tooltip = function (a, b) {
    function c(a, c) {
        c || (c = a, a = "DIV");
        var d = new b.Class(b.Element.Wrappers[a] || b.Element, {
            initialize: function (c, d) {
                this.key = c;
                var e = [{"class": "rui-" + c}];
                this instanceof b.Input || this instanceof b.Form || e.unshift(a), this.$super.apply(this, e), b.isString(d) && (d = b.$(d)), d instanceof b.Element && (this._ = d._, "$listeners"in d && (d.$listeners = d.$listeners), d = {}), this.setOptions(d, this);
                return b.Wrapper.Cache[b.$uid(this._)] = this
            }, setOptions: function (a, c) {
                c && (a = b.Object.merge(a, (new Function("return " + (c.get("data-" + this.key) || "{}")))())), a && b.Options.setOptions.call(this, b.Object.merge(this.options, a));
                return this
            }
        }), e = new b.Class(d, c);
        b.Observer.createShortcuts(e.prototype, e.EVENTS || b([]));
        return e
    }

    var d = b, e = b.$, f = b.$w, g = b.$uid, h = b.Element, i = new c({
        extend: {
            version: "2.2.1",
            EVENTS: f("show hide"),
            Options: {
                cssRule: "[data-tooltip]",
                fxName: "fade",
                fxDuration: 400,
                delay: 400,
                move: !0,
                idSuffix: "-tooltip"
            },
            current: null,
            instances: d([]),
            find: function (a) {
                var b = a.target;
                if (b.match(i.Options.cssRule)) {
                    var c = g(b);
                    return i.instances[c] || (i.instances[c] = new i(b))
                }
            }
        }, initialize: function (b, c) {
            this.associate = b = e(b), this.$super("tooltip").setOptions(c, b).insert('<div class="rui-tooltip-arrow"></div><div class="rui-tooltip-container">' + (b.get("title") || b.get("alt")) + "</div>").on({
                mouseout: this._mouseOut,
                mouseover: this._cancelTimer
            }).insertTo(a.body), b.has("id") && this.set("id", b.get("id") + this.options.idSuffix), b.set({
                title: "",
                alt: ""
            })
        }, hide: function () {
            this._cancelTimer(), this._timer = d(function () {
                h.prototype.hide.call(this, this.options.fxName, {
                    engine: "javascript",
                    duration: this.options.fxDuration
                }), i.current = null, this.fire("hide")
            }).bind(this).delay(100);
            return this
        }, show: function (a) {
            i.instances.each(function (a) {
                a && a !== this && a.hide()
            }, this), this._timer = d(function () {
                h.prototype.show.call(this.stop(), this.options.fxName, {
                    engine: "javascript",
                    duration: this.options.fxDuration
                }), i.current = this.fire("show")
            }).bind(this).delay(this.options.delay);
            return i.current = this
        }, moveToEvent: function (a) {
            this.options.move && (this._.style.left = a.pageX + "px", this._.style.top = a.pageY + "px");
            return this
        }, _cancelTimer: function () {
            this._timer && (this._timer.cancel(), this._timer = null);
            return !1
        }, _mouseOut: function (a) {
            a.stop(), a.relatedTarget !== this.associate && this.hide()
        }
    });
    e(a).on({
        mouseenter: function (a) {
            var b = i.find(a);
            b && b.show().moveToEvent(a)
        }, mouseleave: function (a) {
            var b = i.find(a);
            b && b.hide()
        }, mousemove: function (a) {
            var b = i.current;
            b !== null && b.options.move && b.moveToEvent(a)
        }
    });
    var j = a.createElement("style"), k = a.createTextNode("div.rui-tooltip{display:none;position:absolute;z-index:99999;font-size:90%;margin-top:16pt;margin-left:5pt;color:#FFF;text-shadow:0 0 .2em #000;border:.3em solid rgba(255,255,255,0.2);background-color:rgba(25,25,25,0.92);background-color:#000 \\9;border:.3em solid #444 \\9;background-image:-webkit-gradient(linear,0% 0%,0% 100%,from(transparent) ,to(#000) );border-radius:.4em;-moz-border-radius:.4em;-webkit-border-radius:.4em;box-shadow:0 0 .4em #555;-moz-box-shadow:0 0 .4em #555;-webkit-box-shadow:0 0 .4em #555}div.rui-tooltip-container{margin:.4em .6em}");
    j.type = "text/css", a.getElementsByTagName("head")[0].appendChild(j), j.styleSheet ? j.styleSheet.cssText = k.nodeValue : j.appendChild(k);
    return i
}(document, RightJS)