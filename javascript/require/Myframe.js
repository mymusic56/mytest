/**
 * 在window对象上放了一个自定义的Myframe对象
 */
(function () {
    var document = window.document,
        Myframe = function (selector) {
            return new Myframe.fn.init(selector)
        };
    Myframe.fn = Myframe.prototype = {
        init: function (selector) {
            if (/^#.*/.test(selector)) {
                return document.getElementById(Myframe.fn.shiftFirstStr(selector));
            } else if (/^\..*/.test(selector)) {
                return document.getElementsByClassName(Myframe.fn.shiftFirstStr(selector));
            }
        },
        shiftFirstStr: function (str) {
            return str.substring(1);
        }
    };
    window.Myframe = Myframe;
})();