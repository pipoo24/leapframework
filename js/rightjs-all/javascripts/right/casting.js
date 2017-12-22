/**
 * Dynamic Elements Casting v2.2.0
 * http://rightjs.org/plugins/casting
 *
 * Copyright (C) 2010-2011 Nikolay Nemshilov
 */
(function (a) {
    a.Casting = {version: "2.2.0"};
    var b = null, c = null, d = a.Element.Wrappers;
    a.$ext(d, {
        set: function (a, e) {
            var f = a.match(/^[a-z]+$/i);
            if (f)d[a.toUpperCase()] = e; else if (f = a.match(/^([a-z]*)\#[a-z0-9_\-]+$/i))b === null && (b = {}), b[a] = e; else if (f = a.match(/^([a-z]*)\.[a-z0-9_\-]+$/i))c === null && (c = {}), c[a] = e;
            return e
        }, get: function (e) {
            var f = null;
            typeof e === "string" ? e.toUpperCase()in d ? f = d[e.toUpperCase()] : b !== null && e in b ? f = b[e] : c !== null && e in c && (f = c[e]) : (f = a([]), a([d, b || {}, c || {}]).each(function (a) {
                for (var b in a)a[b] === e && f.push(b)
            }), f = f.compact(), f.empty() && (f = null));
            return f
        }, has: function (a) {
            return d.get(a) !== null
        }, remove: function (e) {
            a([d, b || {}, c || {}]).each(function (a) {
                for (var b in a)(e === b.toLowerCase() || a[b] === e) && delete a[b]
            });
            return d
        }
    }), a.Wrapper.Cast = function (a) {
        var e, f = a.tagName;
        if (b !== null && a.id) {
            e = f.toLowerCase() + "#" + a.id;
            if (e in b)return b[e];
            e = "#" + a.id;
            if (e in b)return b[e]
        }
        if (c !== null && a.className) {
            var g = a.className.split(/\s+/), h = 0, i = f.toLowerCase();
            for (; h < g.length; h++) {
                e = i + "." + g[h];
                if (e in c)return c[e];
                e = "." + g[h];
                if (e in c)return c[e]
            }
        }
        if (f in d)return d[f];
        return undefined
    }
})(RightJS)