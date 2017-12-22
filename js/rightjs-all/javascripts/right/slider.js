/**
 * RightJS-UI Slider v2.3.1
 * http://rightjs.org/ui/slider
 *
 * Copyright (C) 2009-2012 Nikolay Nemshilov
 */
var Slider = RightJS.Slider = function (a, b, c) {
    function q(a) {
        n.current && (n.current = !1)
    }

    function p(a) {
        n.current && n.current.move(a)
    }

    function o(a) {
        var b = a.find(".rui-slider");
        b && (a.stop(), b instanceof n || (b = new n(b)), n.current = b.start(a))
    }

    function d(a, b) {
        b || (b = a, a = "DIV");
        var d = new c.Class(c.Element.Wrappers[a] || c.Element, {
            initialize: function (b, d) {
                this.key = b;
                var e = [{"class": "rui-" + b}];
                this instanceof c.Input || this instanceof c.Form || e.unshift(a), this.$super.apply(this, e), c.isString(d) && (d = c.$(d)), d instanceof c.Element && (this._ = d._, "$listeners"in d && (d.$listeners = d.$listeners), d = {}), this.setOptions(d, this);
                return c.Wrapper.Cache[c.$uid(this._)] = this
            }, setOptions: function (a, b) {
                b && (a = c.Object.merge(a, (new Function("return " + (b.get("data-" + this.key) || "{}")))())), a && c.Options.setOptions.call(this, c.Object.merge(this.options, a));
                return this
            }
        }), e = new c.Class(d, b);
        c.Observer.createShortcuts(e.prototype, e.EVENTS || c([]));
        return e
    }

    var e = {
        assignTo: function (b) {
            var c = f(function (a, b) {
                (a = g(a)) && a[a.setValue ? "setValue" : "update"](b.target.getValue())
            }).curry(b), d = f(function (a, b) {
                a = g(a), a && a.onChange && a.onChange(f(function () {
                    this.setValue(a.value())
                }).bind(b))
            }).curry(b);
            g(b) ? (c({target: this}), d(this)) : g(a).onReady(f(function () {
                c({target: this}), d(this)
            }.bind(this)));
            return this.onChange(c)
        }
    }, f = c, g = c.$, h = c.$$, i = c.$w, j = c.$E, k = c.$A, l = c.isHash, m = c.Element, n = new d({
        include: e,
        extend: {
            version: "2.3.1",
            EVENTS: i("change"),
            Options: {
                min: 0,
                max: 100,
                snap: 0,
                range: !1,
                value: null,
                values: null,
                direction: "x",
                update: null,
                round: 0
            },
            current: !1
        },
        initialize: function () {
            var a = k(arguments).compact(), b = a.pop(), c = a.pop();
            if (!l(b) || b instanceof m)c = g(c || b), b = {};
            this.$super("slider", c).setOptions(b).on("selectstart", "stopEvent"), this.level = this.first(".level") || j("div", {"class": "level"}).insertTo(this), b = this.options, this.value = b.value === null ? b.min : b.value, b.range === !0 ? (this.handles = [], this.handles[0] = this.first(".handle.from") || j("div", {"class": "handle from"}).insertTo(this), this.handles[1] = this.first(".handle.to") || j("div", {"class": "handle to"}).insertTo(this), this.values = [0, 0], this.values[0] = b.values === null ? b.min : b.values[0], this.values[1] = b.values === null ? b.max : b.values[1], this.setValue(this.values[0], "from"), this.setValue(this.values[1], "to")) : (this.handle = this.first(".handle") || j("div", {"class": "handle"}).insertTo(this), this.setValue(this.value)), b.update && this.assignTo(b.update), b.direction === "y" ? this.addClass("rui-slider-vertical") : this.hasClass("rui-slider-vertical") && (b.direction = "y")
        },
        setValue: function (a, b) {
            return this.precalc().shiftTo(a, b)
        },
        getValue: function () {
            return this.options.range === !0 ? this.values[0] : this.value
        },
        getValues: function () {
            return this.values
        },
        insertTo: function (a, b) {
            return this.$super(a, b).setValue(this.value)
        },
        precalc: function () {
            var a = this.options.direction === "x", b = this.dims = this.dimensions();
            if (this.options.range === !0) {
                var c = this.handles[0].setStyle(a ? {left: 0} : {bottom: 0}).dimensions(), d = this.hSize = a ? c.width : c.height;
                this.offset = a ? c.left - b.left : b.top + b.height - c.top - d, this.space = (a ? b.width : b.height) - d - this.offset * 2;
                var e = this.handles[1].setStyle(a ? {left: this.space + "px"} : {bottom: this.space + "px"}).dimensions()
            } else {
                var f = this.handle.setStyle(a ? {left: 0} : {bottom: 0}).dimensions(), d = this.hSize = a ? f.width : f.height;
                this.offset = a ? f.left - b.left : b.top + b.height - f.top - d, this.space = (a ? b.width : b.height) - d - this.offset * 2
            }
            return this
        },
        start: function (a) {
            this._type = null, a.target.hasClass("handle") && (a.target.hasClass("from") ? this._type = "from" : a.target.hasClass("to") && (this._type = "to"));
            return this.precalc().e2val(a)
        },
        move: function (a) {
            return this.e2val(a)
        },
        shiftTo: function (a, c) {
            var d = this.options, e = b.pow(10, d.round), f = d.direction === "x";
            a = b.round(a * e) / e, a < d.min && (a = d.min), a > d.max && (a = d.max);
            if (d.range === !0) {
                c === "to" && a < this.values[0] && (a = this.values[0]);
                if (c === "from" || c === undefined)a > this.values[1] && (a = this.values[1])
            }
            if (d.snap) {
                var g = d.snap, h = (a - d.min) % g;
                a = h < g / 2 ? a - h : a - h + g
            }
            if (d.range === !0) {
                var i = c === "from" ? a : this.values[0], j = c === "to" ? a : this.values[1], k = this.space / (d.max - d.min) * (i - d.min), l = this.space / (d.max - d.min) * (j - d.min), m = l - k;
                c === "to" ? this.handles[1]._.style[f ? "left" : "bottom"] = l + "px" : this.handles[0]._.style[f ? "left" : "bottom"] = k + "px", this.level._.style[f ? "left" : "top"] = (k > 0 ? k : 0) + 2 + "px", this.level._.style[f ? "width" : "height"] = (m > 0 ? m : 0) + 2 + "px";
                var n = !1;
                c === "from" && a !== this.values[0] && (this.values[0] = a, n = !0), c === "to" && a !== this.values[1] && (this.values[1] = a, n = !0), n && this.fire("change", {
                    value: a,
                    values: this.values
                })
            } else {
                var o = this.space / (d.max - d.min) * (a - d.min);
                this.handle._.style[f ? "left" : "bottom"] = o + "px", this.level._.style[f ? "width" : "height"] = (o > 0 ? o : 0) + 2 + "px", a !== this.value && (this.value = a, this.fire("change", {value: a}))
            }
            return this
        },
        e2val: function (a) {
            var b = this.options, c = b.direction === "x", d = this.dims, e = this.offset, f = this.space, g = a.position()[c ? "x" : "y"] - e - this.hSize / 2, h = c ? d.left + e : d.top + e, i = (b.max - b.min) / f * (g - h), j = this._type;
            if (j == null)return this.shiftTo(c ? b.min + i : b.max - i);
            if (j === "to") {
                this.shiftTo(this.values[0], "from");
                return this.shiftTo(c ? b.min + i : b.max - i, "to")
            }
            this.shiftTo(this.values[1], "to");
            return this.shiftTo(c ? b.min + i : b.max - i, "from")
        }
    });
    g(a).on({
        ready: function () {
            h(".rui-slider").each(function (a) {
                a instanceof n || (a = new n(a))
            })
        }, mousedown: o, touchstart: o, mousemove: p, touchmove: p, mouseup: q, touchend: q
    }), g(window).onBlur(function () {
        n.current && (n.current = !1)
    });
    var r = a.createElement("style"), s = a.createTextNode("div.rui-slider,div.rui-slider .handle,div.rui-slider .level{margin:0;padding:0;border:none;background:none}div.rui-slider{height:0.4em;width:20em;border:1px solid #bbb;background:#F8F8F8;border-radius:.2em;-moz-border-radius:.2em;-webkit-border-radius:.2em;position:relative;margin:.6em 0;display:inline-block; *display:inline; *zoom:1;vertical-align:middle;user-select:none;-moz-user-select:none;-webkit-user-select:none;cursor:pointer}div.rui-slider .handle{font-size:25%;position:absolute;left:0;top:0;width:4pt;height:10pt;margin-top:-4pt;margin-left:0.4em;background:#BBB;border:1px solid #999;border-radius:.8em;-moz-border-radius:.8em;-webkit-border-radius:.8em;z-index:20}div.rui-slider .level{font-size:25%;position:absolute;top:0;left:0;width:0;height:100%;background:#ddd;z-index:1}div.rui-slider-vertical{height:10em;width:0.4em;margin:0 .3em}div.rui-slider-vertical .handle{top:auto;bottom:0;margin:0;margin-left:-4pt;margin-bottom:0.4em;height:5pt;width:10pt}div.rui-slider-vertical .level{height:0;width:100%;top:auto;bottom:0}");
    r.type = "text/css", a.getElementsByTagName("head")[0].appendChild(r), r.styleSheet ? r.styleSheet.cssText = s.nodeValue : r.appendChild(s);
    return n
}(document, Math, RightJS)