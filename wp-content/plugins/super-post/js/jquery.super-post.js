/*
    Super Post
	http://codecanyon.net/item/super-post-wordpress-premium-plugin/741603?ref=zourbuth
    Author: zourbuth
    Author URI: http://zourbuth.com
    License: GPL2

	Copyright 2013 zourbuth.com (email : zourbuth@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	For discussion please visit:
	http://codecanyon.net/item/super-post-wordpress-premium-plugin/discussion/741603?ref=zourbuth
*/

(function($) {
	SpSharer = {
		init : function( url ) {
			if ( $( '#spsharer-facebook-' + superPost.share[ url ] ).length )
				$.getScript( 'https://graph.facebook.com/' + encodeURIComponent( url ) + '?callback=SpSharer.facebook_count' );
			if ( $( '#spsharer-google-' + superPost.share[ url ] ).length )
				$.post( superPost.ajaxurl, { action: superPost.google_plus, url: url, nonce : superPost.nonce }, function( data ) { SpSharer.google_count( data ); }, "json");
			if ( $( '#spsharer-twitter-' + superPost.share[ url ] ).length )
				$.getScript( window.location.protocol + '//cdn.api.twitter.com/1/urls/count.json?callback=SpSharer.twitter_count&url=' + encodeURIComponent( url ) );
			if ( $( '#spsharer-linkedin-' + superPost.share[ url ] ).length )
				$.getScript( window.location.protocol + '//www.linkedin.com/countserv/count/share?format=jsonp&callback=SpSharer.linkedin_count&url=' + encodeURIComponent( url ) );
		},
		twitter_count : function( data ) {
			if ( 'undefined' != typeof data.count && ( data.count * 1 ) > 0 ) {
				SpSharer.append_count( 'spsharer-twitter-' + superPost.share[ data.url ], data.count );
			}
		},
		google_count : function( data ) {			
			if ( data && ( data.count * 1 ) > 0 ) {	// this will returns error in localhost
				SpSharer.append_count( 'spsharer-google-' + superPost.share[ data.url ], data.count );
			}
		},
		facebook_count : function( data ) {	
			if ( 'undefined' != typeof data.shares && ( data.shares * 1 ) > 0 ) {	// this will returns error in localhost
				SpSharer.append_count( 'spsharer-facebook-' + superPost.share[ data.id ], data.shares );
			}
		},
		linkedin_count : function( data ) {
			if ( 'undefined' != typeof data.count && ( data.count * 1 ) > 0 ) {
				SpSharer.append_count( 'spsharer-linkedin-' + superPost.share[ data.url ], data.count );
			}
		},
		append_count : function( id, count ) {
			$( '#' + id + ' span' ).append( '<span class="count">' + SpSharer.format_count( count ) + '</span>' );
		},
		format_count : function( count ) {
			if ( count < 1000 )
				return count;
			if ( count >= 1000 && count < 10000 )
				return String( count ).substring( 0, 1 ) + 'K';
			return '10K';
		}
	};
})(jQuery);


jQuery(document).ready(function($){

	// Image hover function
	$("img.sp-thumbnail").live("mouseover", function(){
	   $(this).stop().animate({opacity:0.5},400);
	}).live("mouseout", function(){
	   $(this).stop().animate({opacity:1},400);
	});	

	$("div.sp-load-more > a").live("click", function(e){
		e.preventDefault();
		
		if( $(this).hasClass("sp-inactive") ) {			
			return;
		}
			
		var t = $(this), 
		cur = t.parent(), 
		sibl = cur.prev(), 
		id = Number(cur.attr("data-id")),
		offset = Number(cur.attr("data-offset")),
		paging = cur.attr("data-load"),
		height = cur.height();
		
		if( "paging" == paging )
			offset = Number(cur.attr("data-offset")) * ( Number(t.text()) - 1);

		cur.append("<span class='sp-loading'>Loading...</span>");

		$.post( superPost.ajaxurl, { action: superPost.paging, id: id, offset: offset, nonce : superPost.nonce }, function(data){
			$(".sp-loading", cur).remove();			
			if( "paging" == paging ) {
				if (data) {
					$(sibl).fadeOut( "fast" ,function(){
						$('html, body').animate({scrollTop:$(cur).offset().top - 30}, 1000);
						$(this).empty().append(data).slideToggle();
						t.siblings().removeClass("sp-inactive");
						t.addClass("sp-inactive");
					});	
				}
			} else {
				if (data) {
					$('html, body').animate({scrollTop:$(cur).offset().top - 30}, 1000);
					$(data).hide().appendTo(sibl).slideDown("slow");			
					cur.attr("data-offset", ( Number(cur.attr("data-offset")) + offset) );
				} else {
					$("a", cur).remove();
				}
			}
		});
	});
	
	if ( 'undefined' != typeof superPost ) {
		for ( var id in superPost.share ) {
			SpSharer.init( id );
		}
	}	
});


(function($) {
SuperPostShare = {

	init : function(){
		var t = this;
		this.sendingMail = false
		
		$("a.spsharer").click( function(e) {
			t.linked(e, $(this).attr("href") );
		});
		
		$(".spsharer-email").click( function(e) {
			t.toggle(e, $(this).closest("ul"));
		});
		
		$("#sphare-email form").submit(function(e) {
			t.share(e, $(this));
		});
		
		$(".sp-mail-cancel").click( function(e) {
			t.cancel(e);
		});
	},
	
	toggle : function(e, u){
		e.preventDefault();
		$(u).after( $("#sphare-email") );
		$("#sphare-email").slideToggle( 200 );
	},
	
	share : function(e, p){
	
		e.preventDefault();
		
		if( this.sendingMail )
			return;
		
		var t = this, form = $(p), is_email, emailInput, splitEmail, message, id, seri, invalidEmail, formdata, sender, name;

		emailInput = $('input[name*="recipient"]', form).val();

		splitEmail = emailInput.replace(/ /g,'').split(",");
		
		email_regex = /^(?!-)[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		
		$.each( splitEmail, function(index, email) {
			if( email_regex.test( email ) ) {
				message = '<span class="loading"></span> Please Wait...';
				is_email = true;
			} else {
				message = '<span class="sp-error">Invalid email <em>'+email+'</em></span>';
				is_email = false;
			}
		});
		
		if( ! $('input[name*="sender"]', form).val() ) {
			console.log( $('input[name*="sender"]', form).val() );
			message = '<span class="sp-error">Please fill your email address</span>';
			is_email = false;
		}
		
		$('#sp-response', form).fadeIn( 500, function() {
			$(this).html(message);
		});

		if( is_email ) {
			t.sendingMail = true;
			id = $(form).parent("#sphare-email").prev().attr("data-id");
			formdata = form.serialize();
			$.post( superPost.ajaxurl, { action: superPost.sendmail, id: id, data: formdata, nonce: superPost.nonce }, function( data ){
				$('#sp-response', form).fadeIn( 500, function() {
					$(this).html(data);
				});
				t.sendingMail = false;
				$(".loading", form).hide();
			});
		}
	},
	
	linked : function(e, href){
		e.preventDefault();
		var left = ( screen.width/2 ) - 250, 
		top = ( screen.height/2 ) - 250;
		pop=window.open( href, '', 'height=500,width=500, top='+top+', left='+left );
		if ( window.focus ) { pop.focus() }; return false;
	},
	
	cancel : function(e){
		e.preventDefault();
		$("#sphare-email").slideToggle();
	}	
};

$(document).ready(function(){SuperPostShare.init();});
})(jQuery);


(function($) {
SuperPostUtility = {

	init : function(){
		var t = this, getRates = false, getLikes = false;
		$("a.sp-likes").click( function(e) {
			t.likes(e, $(this));
		});
		$("span.sp-rates").each( function() {
			t.rate($(this));
		});
	},
	
	rate : function(e){
		var t = this, rate, star, c, cookies;			
		
		t.starInit(e);
		
		$("span > span", e).hover( function(i) {
			c = $(this).index() + 1;
			$("span > span:lt("+c+")", e).addClass("hover");
		}, function () {
			$("span > span", e).removeClass("hover");
		});
		
		$("span > span", e).click( function(i) {
			star = $(this).index();
			c = $(this);
			
			// Check for the rate cookie		
			if( cookies = t.getCookie("rates") ) {
				$.each( cookies, function (index, value) {							
					if( t.getId(e) == value ) {						
						return t.getRates = true;
					}
				});
			}
			
			if( t.getRates ) {
				alert( superPost.rates.error );
				return;
			}
						
			// Update the like counter via ajax
			t.getRates = true;
			$.post( superPost.ajaxurl, { action: superPost.rates.action, id: t.getId(e), star: star+1, nonce: superPost.nonce }, function( data ){
				$(c).parent("span").attr("data-rate", data);
				t.starInit(e);
				t.getRates = false;
			});			
		});
	},
	
	starInit : function(e){
		var rate = $("span", e).attr("data-rate");
		$("span > span", e).each( function(i) {
			$(this).removeAttr("class");
			$("span > span:lt("+Math.floor(rate)+")", e).addClass("star-full");
			if( rate % 1 != 0 )
				$("span > span", e).eq(Math.floor(rate)).addClass("star-half");
		});
	},
	
	likes : function(e, o){
		var t = this, c, cookies;
		e.preventDefault();

		// Check for the like cookie		
		if( cookies = t.getCookie("likes") ) {
			$.each( cookies, function (index, value) {							
				if( t.getId(o) == value ) {					
					return t.getLikes = true;
				}
			});
		}		
		
		if( t.getLikes ) {
			alert( superPost.likes.error );
			return;
		}

		// Update the like counter via ajax
		t.getLikes = true;
		$.post( superPost.ajaxurl, { action: superPost.likes.action, id: t.getId(o), nonce: superPost.nonce }, function( data ){
			$("span", o).html(data);
			t.getLikes = false;
		});
	},
	
	getCookie : function(key) {
		var c, s, j, cookies;
        c = document.cookie.split('; ');
        cookies = {};

        for( i=c.length-1; i>=0; i-- ){
           s = c[i].split('=');
           cookies[s[0]] = unescape(s[1]);
        }
		
		if( cookies["super_post"] ) {
			j = $.parseJSON( cookies['super_post'] );
			if( j[key] )
				return j[key];
			else
				return false;
		} else {
			return false;
		}
	},
	
	getId : function(o) {
		var id = $(o).closest('ul').attr('id'),		
		parts = id.split('-');	
		return parts[parts.length - 1];
	}	
};

$(document).ready(function(){SuperPostUtility.init();});
})(jQuery);


(function($) {
SuperPostSearch = {	
	init : function(){
		var t = this, search, ul, cur;
		$('input.sp-search').keyup(function() {
			cur = $(this);
			search = cur.val();
			if ( search.length > 2 ) {
				clearTimeout( $.data(this, 'sptimer') );
				var wait = setTimeout(function(){
					t.search(cur, 1);
				}, 750);
				$(this).data('sptimer', wait);
			}
		});
		
		$("li.sp-search-more > a").live("click", function(e) {
			e.preventDefault();
	
			if( ! $(this).hasClass("sp-inactive") )
				t.search(cur, Number($(this).text()));
		});
	},
	
	search: function(e, page) {
		var t = this, params = {};
		$(e).addClass("sp-search-loading");
		$.post( superPost.ajaxurl, { action: superPost.search, page:page, search: e.val(), nonce: superPost.nonce }, function( data ){			
			ul = $(e).parents(".sp-search-wrapper").find("ul");
			$(ul).empty().hide().append( data ).fadeIn();
			$(e).removeClass("sp-search-loading");
		});
	}
};

$(document).ready(function(){SuperPostSearch.init();});
})(jQuery);