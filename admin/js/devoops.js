//
//    Main script of DevOOPS v1.0 Bootstrap Theme
//
"use strict";
/*-------------------------------------------
	Dynamically load plugin scripts
---------------------------------------------*/
//
// Dynamically load Fullcalendar Plugin Script
// homepage: http://arshaw.com/fullcalendar
// require moment.js
//
function LoadCalendarScript(callback){
	function LoadFullCalendarScript(){
		if(!$.fn.fullCalendar){
			$.getScript('plugins/fullcalendar/fullcalendar.js', callback);
		}
		else {
			if (callback && typeof(callback) === "function") {
				callback();
			}
		}
	}
	if (!$.fn.moment){
		$.getScript('plugins/moment/moment.min.js', LoadFullCalendarScript);
	}
	else {
		LoadFullCalendarScript();
	}
}

//
//  Dynamically load Bootstrap Validator Plugin
//  homepage: https://github.com/nghuuphuoc/bootstrapvalidator
//
function LoadBootstrapValidatorScript(callback){
	if (!$.fn.bootstrapValidator){
		$.getScript('plugins/bootstrapvalidator/bootstrapValidator.min.js', callback);
	}
	else {
		if (callback && typeof(callback) === "function") {
			callback();
		}
	}
}
//
//  Dynamically load jQuery Select2 plugin
//  homepage: https://github.com/ivaynberg/select2  v3.4.5  license - GPL2
//
function LoadSelect2Script(callback){
	if (!$.fn.select2){
		$.getScript('plugins/select2/select2.min.js', callback);
	}
	else {
		if (callback && typeof(callback) === "function") {
			callback();
		}
	}
}
//
//  Dynamically load DataTables plugin
//  homepage: http://datatables.net v1.9.4 license - GPL or BSD
//
function LoadDataTablesScripts(callback){
	function LoadDatatables(){
		$.getScript('plugins/datatables/jquery.dataTables.js', function(){
			$.getScript('plugins/datatables/ZeroClipboard.js', function(){
				$.getScript('plugins/datatables/TableTools.js', function(){
					$.getScript('plugins/datatables/dataTables.bootstrap.js', callback);
				});
			});
		});
	}
	if (!$.fn.dataTables){
		LoadDatatables();
	}
	else {
		if (callback && typeof(callback) === "function") {
			callback();
		}
	}
}

//
//  Dynamically load Fancybox 2 plugin
//  homepage: http://fancyapps.com/fancybox/ v2.1.5 License - MIT
//
function LoadFancyboxScript(callback){
	if (!$.fn.fancybox){
		$.getScript('plugins/fancybox/jquery.fancybox.js', callback);
	}
	else {
		if (callback && typeof(callback) === "function") {
			callback();
		}
	}
}

/*-------------------------------------------
	Main scripts used by theme
---------------------------------------------*/
//
//  Function for load content from url and put in $('.ajax-content') block
//
/*
function LoadAjaxContent(url){
	$('.preloader').show();
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: url,
		type: 'GET',
		success: function(data) {
			$('#ajax-content').html(data);
			$('.preloader').hide();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});
}
*/
//
//  Function maked all .box selector is draggable, to disable for concrete element add class .no-drop
//
function WinMove(){
	$( "div.box").not('.no-drop')
		.draggable({
			revert: true,
			zIndex: 2000,
			cursor: "crosshair",
			handle: '.box-name',
			opacity: 0.8
		})
		.droppable({
			tolerance: 'pointer',
			drop: function( event, ui ) {
				var draggable = ui.draggable;
				var droppable = $(this);
				var dragPos = draggable.position();
				var dropPos = droppable.position();
				draggable.swap(droppable);
				setTimeout(function() {
					var dropmap = droppable.find('[id^=map-]');
					var dragmap = draggable.find('[id^=map-]');
					if (dragmap.length > 0 || dropmap.length > 0){
						dragmap.resize();
						dropmap.resize();
					}
					else {
						draggable.resize();
						droppable.resize();
					}
				}, 50);
				setTimeout(function() {
					draggable.find('[id^=map-]').resize();
					droppable.find('[id^=map-]').resize();
				}, 250);
			}
		});
}
//
// Swap 2 elements on page. Used by WinMove function
//
jQuery.fn.swap = function(b){
	b = jQuery(b)[0];
	var a = this[0];
	var t = a.parentNode.insertBefore(document.createTextNode(''), a);
	b.parentNode.insertBefore(a, b);
	t.parentNode.insertBefore(b, t);
	t.parentNode.removeChild(t);
	return this;
};
//
//  Screensaver function
//  used on locked screen, and write content to element with id - canvas
//
function ScreenSaver(){
	var canvas = document.getElementById("canvas");
	var ctx = canvas.getContext("2d");
	// Size of canvas set to fullscreen of browser
	var W = window.innerWidth;
	var H = window.innerHeight;
	canvas.width = W;
	canvas.height = H;
	// Create array of particles for screensaver
	var particles = [];
	for (var i = 0; i < 25; i++) {
		particles.push(new Particle());
	}
	function Particle(){
		// location on the canvas
		this.location = {x: Math.random()*W, y: Math.random()*H};
		// radius - lets make this 0
		this.radius = 0;
		// speed
		this.speed = 3;
		// random angle in degrees range = 0 to 360
		this.angle = Math.random()*360;
		// colors
		var r = Math.round(Math.random()*255);
		var g = Math.round(Math.random()*255);
		var b = Math.round(Math.random()*255);
		var a = Math.random();
		this.rgba = "rgba("+r+", "+g+", "+b+", "+a+")";
	}
	// Draw the particles
	function draw() {
		// re-paint the BG
		// Lets fill the canvas black
		// reduce opacity of bg fill.
		// blending time
		ctx.globalCompositeOperation = "source-over";
		ctx.fillStyle = "rgba(0, 0, 0, 0.02)";
		ctx.fillRect(0, 0, W, H);
		ctx.globalCompositeOperation = "lighter";
		for(var i = 0; i < particles.length; i++){
			var p = particles[i];
			ctx.fillStyle = "white";
			ctx.fillRect(p.location.x, p.location.y, p.radius, p.radius);
			// Lets move the particles
			// So we basically created a set of particles moving in random direction
			// at the same speed
			// Time to add ribbon effect
			for(var n = 0; n < particles.length; n++){
				var p2 = particles[n];
				// calculating distance of particle with all other particles
				var yd = p2.location.y - p.location.y;
				var xd = p2.location.x - p.location.x;
				var distance = Math.sqrt(xd*xd + yd*yd);
				// draw a line between both particles if they are in 200px range
				if(distance < 200){
					ctx.beginPath();
					ctx.lineWidth = 1;
					ctx.moveTo(p.location.x, p.location.y);
					ctx.lineTo(p2.location.x, p2.location.y);
					ctx.strokeStyle = p.rgba;
					ctx.stroke();
					//The ribbons appear now.
				}
			}
			// We are using simple vectors here
			// New x = old x + speed * cos(angle)
			p.location.x = p.location.x + p.speed*Math.cos(p.angle*Math.PI/180);
			// New y = old y + speed * sin(angle)
			p.location.y = p.location.y + p.speed*Math.sin(p.angle*Math.PI/180);
			// You can read about vectors here:
			// http://physics.about.com/od/mathematics/a/VectorMath.htm
			if(p.location.x < 0) p.location.x = W;
			if(p.location.x > W) p.location.x = 0;
			if(p.location.y < 0) p.location.y = H;
			if(p.location.y > H) p.location.y = 0;
		}
	}
	setInterval(draw, 30);
}
//
// Helper for draw Google Chart
//
function drawGoogleChart(chart_data, chart_options, element, chart_type) {
	// Function for visualize Google Chart
	var data = google.visualization.arrayToDataTable(chart_data);
	var chart = new chart_type(document.getElementById(element));
	chart.draw(data, chart_options);
}

//
// Create OpenLayers map with required options and return map as object
//
function drawMap(lon, lat, elem, layers) {
	var LayersArray = [];
	// Map initialization
	var map = new OpenLayers.Map(elem);
	// Add layers on map
	map.addLayers(layers);
	// WGS 1984 projection
	var epsg4326 =  new OpenLayers.Projection("EPSG:4326");
	//The map projection (Spherical Mercator)
	var projectTo = map.getProjectionObject();
	// Max zoom = 17
	var zoom=10;
	map.zoomToMaxExtent();
	// Set longitude/latitude
	var lonlat = new OpenLayers.LonLat(lon, lat);
	map.setCenter(lonlat.transform(epsg4326, projectTo), zoom);
	var layerGuest = new OpenLayers.Layer.Vector("You are here");
	// Define markers as "features" of the vector layer:
	var guestMarker = new OpenLayers.Feature.Vector(
		new OpenLayers.Geometry.Point(lon, lat).transform(epsg4326, projectTo)
	);
	layerGuest.addFeatures(guestMarker);
	LayersArray.push(layerGuest);
	map.addLayers(LayersArray);
	// If map layers > 1 then show checker
	if (layers.length > 1){
		map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':true}));
	}
	// Link to current position
	map.addControl(new OpenLayers.Control.Permalink());
	// Show current mouse coords
	map.addControl(new OpenLayers.Control.MousePosition({ displayProjection: epsg4326 }));
	return map
}


//
//  Helper for correct size of Messages page
//
function MessagesMenuWidth(){
	var W = window.innerWidth;
	var W_menu = $('#sidebar-left').outerWidth();
	var w_messages = (W-W_menu)*16.666666666666664/100;
	$('#messages-menu').width(w_messages);
}
//
// Function for change panels of Dashboard
//
function DashboardTabChecker(){
	$('#content').on('click', 'a.tab-link', function(e){
		e.preventDefault();
		$('div#dashboard_tabs').find('div[id^=dashboard]').each(function(){
			$(this).css('visibility', 'hidden').css('position', 'absolute');
		});
		var attr = $(this).attr('id');
		$('#'+'dashboard-'+attr).css('visibility', 'visible').css('position', 'relative');
		$(this).closest('.nav').find('li').removeClass('active');
		$(this).closest('li').addClass('active');
	});
}

//
//  Beauty tables plugin (navigation in tables with inputs in cell)
//  Created by DevOOPS.
//
(function( $ ){
	$.fn.beautyTables = function() {
		var table = this;
		var string_fill = false;
		this.on('keydown', function(event) {
		var target = event.target;
		var tr = $(target).closest("tr");
		var col = $(target).closest("td");
		if (target.tagName.toUpperCase() == 'INPUT'){
			if (event.shiftKey === true){
				switch(event.keyCode) {
					case 37: // left arrow
						col.prev().children("input[type=text]").focus();
						break;
					case 39: // right arrow
						col.next().children("input[type=text]").focus();
						break;
					case 40: // down arrow
						if (string_fill==false){
							tr.next().find('td:eq('+col.index()+') input[type=text]').focus();
						}
						break;
					case 38: // up arrow
						if (string_fill==false){
							tr.prev().find('td:eq('+col.index()+') input[type=text]').focus();
						}
						break;
				}
			}
			if (event.ctrlKey === true){
				switch(event.keyCode) {
					case 37: // left arrow
						tr.find('td:eq(1)').find("input[type=text]").focus();
						break;
					case 39: // right arrow
						tr.find('td:last-child').find("input[type=text]").focus();
						break;
				case 40: // down arrow
					if (string_fill==false){
						table.find('tr:last-child td:eq('+col.index()+') input[type=text]').focus();
					}
					break;
				case 38: // up arrow
					if (string_fill==false){
						table.find('tr:eq(1) td:eq('+col.index()+') input[type=text]').focus();
					}
						break;
				}
			}
			if (event.keyCode == 13 || event.keyCode == 9 ) {
				event.preventDefault();
				col.next().find("input[type=text]").focus();
			}
			if (string_fill==false){
				if (event.keyCode == 34) {
					event.preventDefault();
					table.find('tr:last-child td:last-child').find("input[type=text]").focus();}
				if (event.keyCode == 33) {
					event.preventDefault();
					table.find('tr:eq(1) td:eq(1)').find("input[type=text]").focus();}
			}
		}
		});
		table.find("input[type=text]").each(function(){
			$(this).on('blur', function(event){
			var target = event.target;
			var col = $(target).parents("td");
			if(table.find("input[name=string-fill]").prop("checked")==true) {
				col.nextAll().find("input[type=text]").each(function() {
					$(this).val($(target).val());
				});
			}
		});
	})
};
})( jQuery );
//
// Beauty Hover Plugin (backlight row and col when cell in mouseover)
//
//
(function( $ ){
	$.fn.beautyHover = function() {
		var table = this;
		table.on('mouseover','td', function() {
			var idx = $(this).index();
			var rows = $(this).closest('table').find('tr');
			rows.each(function(){
				$(this).find('td:eq('+idx+')').addClass('beauty-hover');
			});
		})
		.on('mouseleave','td', function(e) {
			var idx = $(this).index();
			var rows = $(this).closest('table').find('tr');
			rows.each(function(){
				$(this).find('td:eq('+idx+')').removeClass('beauty-hover');
			});
		});
	};
})( jQuery );
//
//  Function convert values of inputs in table to JSON data
//
//
function Table2Json(table) {
	var result = {};
	table.find("tr").each(function () {
		var oneRow = [];
		var varname = $(this).index();
		$("td", this).each(function (index) { if (index != 0) {oneRow.push($("input", this).val());}});
		result[varname] = oneRow;
	});
	var result_json = JSON.stringify(result);
	OpenModalBox('Table to JSON values', result_json);
}

function DrawAllCharts(){

	var vendas2014 = [
 	['Ano', '2014'],
		['Janeiro',  1000],
		['Fevereiro',  1170],
		['Março',  6600],
		['Abril',  1030],
		['Maio',  2080],
		['Junho',  1949],
		['Julho',  100]
	];
	var vendas2014_options = {
		backgroundColor: '#fcfcfc',
		title: 'Vendas 2014'
	};
	var vendas2014_element = 'vendas-2014';
	drawGoogleChart(vendas2014, vendas2014_options, vendas2014_element, google.visualization.LineChart);
	
	
	var vendasGeral = [
	                   ['Ano', '2013', '2014'],
	                   ['Janeiro', 100, 200],
	                   ['Fevereiro', 200, 140],
	                   ['Março', 400, 100],
	                   ['Junho', 111, 600],
	                   ['Julho', 1000, 1100]
 ];
	var vendasGeral_options = {
	    backgroundColor: '#fcfcfc',
	    title: "Vendas (2013-2014)"
	};
	
	var vendasGeral_element = 'vendas-geral';
	
 drawGoogleChart(vendasGeral, vendasGeral_options, vendasGeral_element, google.visualization.LineChart);
	
}


/*-------------------------------------------
	Function for Fullscreen Map page (map_fullscreen.html)
---------------------------------------------*/
//
// Create Fullscreen Map
//
function FullScreenMap(){
	$.getJSON("http://www.telize.com/geoip?callback=?",
		function(json) {
			var osmap = new OpenLayers.Layer.OSM("OpenStreetMap");//создание слоя карты
			var googlestreets = new OpenLayers.Layer.Google("Google Streets", {numZoomLevels: 22,visibility: false});
			var googlesattelite = new OpenLayers.Layer.Google( "Google Sattelite", {type: google.maps.MapTypeId.SATELLITE, numZoomLevels: 22});
			var map1_layers = [googlestreets,osmap, googlesattelite];
			var map_fs = drawMap(json.longitude, json.latitude, "full-map", map1_layers);
		}
	);
}
/*-------------------------------------------
	Function for Flickr Gallery page (gallery_flickr.html)
---------------------------------------------*/
//
// Load data from Flicks, parse and create gallery
//
function displayFlickrImages(data){
	var res;
	$.each(data.items, function(i,item){
		if (i >11) { return false;}
		res = "<a href=" + item.link + " title=" + item.title + " target=\"_blank\"><img alt=" + item.title + " src=" + item.media.m + " /></a>";
		$('#box-one-content').append(res);
		});
		setTimeout(function(){
			$("#box-one-content").justifiedGallery({
				'usedSuffix':'lt240',
				'justifyLastRow':true,
				'rowHeight':150,
				'fixedHeight':false,
				'captions':true,
				'margins':1
				});
			$('#box-one-content').fadeIn('slow');
		}, 100);
}


function alert(message, callback){
  var modal = '<div class="modal fade">';
      modal += '<div class="modal-dialog">';
      modal += '<div class="modal-content">';
      modal += '<div class="modal-header">';
      modal += '  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
      modal += '  <h4 class="modal-title">Aviso</h4>';
      modal += '</div>';
      modal += '<div class="modal-body">';
      modal +=   '<p>'+message+'</p>';
      modal += '</div>';
      modal += '<div class="modal-footer">';
      modal +=   '<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>';
      modal += '</div>';
      modal += '</div>';
      modal += '</div>';
      modal += '</div>';
  $(modal).prependTo('body').modal('show').on('hide.bs.modal', function(){
    if(callback){
      callback();
    }
  });
}

function confirm(message, callback){
  var modal = '<div class="modal fade">';
      modal += '<div class="modal-dialog">';
      modal += '<div class="modal-content">';
      modal += '<div class="modal-header">';
      modal += '  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
      modal += '  <h4 class="modal-title">Aviso</h4>';
      modal += '</div>';
      modal += '<div class="modal-body">';
      modal +=   '<p>'+message+'</p>';
      modal += '</div>';
      modal += '<div class="modal-footer">';
      modal +=   '<button type="button" class="btn btn-danger confirm-false" data-dismiss="modal">Não</button>';
      modal +=   '<button type="button" class="btn btn-success confirm-true" data-dismiss="modal">Sim</button>';
      modal += '</div>';
      modal += '</div>';
      modal += '</div>';
      modal += '</div>';
  $(modal).prependTo('body').modal('show').find('.confirm-true').on('click', function(){
    if(callback){
      callback();
    }
  });
}

function showEnabledPage(page){
  $('li a[data-model="'+page+'"]').click();
}

$(document).ready(function () {
  
 $.ajaxSetup({
   beforeSend: function(){
     $('body').css("cursor", "progress");
   },
   complete: function(){
     $('body').css('cursor', '');
   }
 });
  
	$('.show-sidebar').on('click', function (e) {
		e.preventDefault();
		$('div#main').toggleClass('sidebar-show');
		setTimeout(MessagesMenuWidth, 250);
	});
	if(navigator.userAgent.indexOf("Android")>-1 && $(window).width() <= 480){
	  $('.show-sidebar').click();
	}
	$('.main-menu a').on('click', function (e) {
		var parents = $(this).parents('li');
		var li = $(this).closest('li.dropdown');
		var another_items = $('.main-menu li').not(parents);
		another_items.find('a').removeClass('active');
		another_items.find('a').removeClass('active-parent');
		if ($(this).hasClass('dropdown-toggle') || $(this).closest('li').find('ul').length == 0) {
			$(this).addClass('active-parent');
			var current = $(this).next();
			if (current.is(':visible')) {
				li.find("ul.dropdown-menu").slideUp('fast');
				li.find("ul.dropdown-menu a").removeClass('active');
			}
			else {
				another_items.find("ul.dropdown-menu").slideUp('fast');
				current.slideDown('fast');
			}
		}
		else {
			if (li.find('a.dropdown-toggle').hasClass('active-parent')) {
				var pre = $(this).closest('ul.dropdown-menu');
				pre.find("li.dropdown").not($(this).closest('li')).find('ul.dropdown-menu').slideUp('fast');
			}
		}
		if ($(this).hasClass('active') == false) {
			$(this).parents("ul.dropdown-menu").find('a').removeClass('active');
			$(this).addClass('active');
		}
		if ($(this).attr('href') == '#') {
			e.preventDefault();
		}
	});
	var height = window.innerHeight - 49;
	$('#main').css('min-height', height)
		.on('click', '.expand-link', function (e) {
			var body = $('body');
			e.preventDefault();
			var box = $(this).closest('div.box');
			var button = $(this).find('i');
			button.toggleClass('fa-expand').toggleClass('fa-compress');
			box.toggleClass('expanded');
			body.toggleClass('body-expanded');
			var timeout = 0;
			if (body.hasClass('body-expanded')) {
				timeout = 100;
			}
			setTimeout(function () {
				box.toggleClass('expanded-padding');
			}, timeout);
			setTimeout(function () {
				box.resize();
				box.find('[id^=map-]').resize();
			}, timeout + 50);
		})
		.on('click', '.collapse-link', function (e) {
			e.preventDefault();
			var box = $(this).closest('div.box');
			var button = $(this).find('i');
			var content = box.find('div.box-content');
			content.slideToggle('fast');
			button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
			setTimeout(function () {
				box.resize();
				box.find('[id^=map-]').resize();
			}, 50);
		})
		.on('click', '.close-link', function (e) {
			e.preventDefault();
			var content = $(this).closest('div.box');
			content.remove();
		});
	$('#locked-screen').on('click', function (e) {
		e.preventDefault();
		$('body').addClass('body-screensaver');
		$('#screensaver').addClass("show");
		ScreenSaver();
	});
	$('body').on('click', 'a.close-link', function(e){
		e.preventDefault();
		CloseModalBox();
	});
	$('#screen_unlock').on('mouseover', function(){
		var header = 'Enter current username and password';
		var form = $('<div class="form-group"><label class="control-label">Username</label><input type="text" class="form-control" name="username" /></div>'+
					'<div class="form-group"><label class="control-label">Password</label><input type="password" class="form-control" name="password" /></div>');
		var button = $('<div class="text-center"><a href="index.html" class="btn btn-primary">Unlock</a></div>');
		OpenModalBox(header, form, button);
	});
	
	$('.delete').on('click', function(e){
	  e.preventDefault();
   var confirmacao = "",
       href = $(this).attr('href');
	  if($(this).attr('data-confirm')){
	    confirmacao = $(this).attr('data-confirm');
	  }else{
	    confirmacao = "Deseja realmente apagar este item?";
	  }
	  confirm(confirmacao, function(){
	    location.href=href;
	  });
	});
	
	
	if("tinymce" in $(window)){
   tinymce.init({
     selector: "textarea.tmce",
     theme: "modern",
     language: "pt_BR",
     cleanup: false,
     verify_html: false,
     skin: "admin",
     //content_css: '',
     plugins: [
         "advlist autolink lists link image charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars code fullscreen",
         "insertdatetime media nonbreaking save table contextmenu directionality responsivefilemanager",
         "emoticons template paste textcolor codemirror"
     ],
     relative_urls: false,
     browser_spellcheck : true ,
     filemanager_title:"Gerenciador de arquivos",
     external_filemanager_path:"plugins/tinymce/plugins/filemanager/",
     external_plugins: { "filemanager" : "plugins/filemanager/plugin.min.js" },
     codemirror: {
       indentOnInit: true, // Whether or not to indent code on init. 
       path: '../codemirror', // Path to CodeMirror distribution
       config: {           // CodeMirror config object
          mode: 'application/x-httpd-php',
          lineNumbers: false
       },
       jsFiles: [          // Additional JS files to load
          'mode/clike/clike.js',
          'mode/php/php.js'
       ]
     },
     image_advtab: true,
     toolbar1: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager media image",
     toolbar2: "print preview media | forecolor backcolor emoticons"
   });
	}
	
 $('input.datetime').datetimepicker({
   inline : true,
   lang : "pt",
   format : "Y-m-d H:i",
   defaultSelect : false
 });

 $('.recursive').each(function() {
   var parent = $(this).attr('data-parent');
   parent = $('.recursive[data-id="' + parent + '"]');
   if (parent.length) {
     var left = parent.css('padding-left');
     $(this).css('padding-left', '+=' + left);
     $(this).insertAfter(parent);
   }
 });

 $('#tags').tagsinput();
 
 $('.link-tag').on('click', function(e){
   e.preventDefault();
   var tag = $(this).text();
    $('#tags').tagsinput('add', tag);
 });
 $('.link-tag').last().next('i').remove();

 $('.check').bind('change', function() {
   var el = $($(this).attr('data-toggle'));
   el.fadeToggle();
 }).trigger('change');
 
 $('.table-banners tbody').sortable({
   cursor: "move",
   start: function(a,b){
     $(b.item).css('background', '#FEFFBA');
   },
   stop: function(a,b){
     $(b.item).css('background', '');
     var id = b.item.attr('data-id'),
         newPosition = b.item.index();
     $.ajax({
       url: "ajax/reordbanners.php",
       type: "POST",
       data:{
         id: id,
         position: newPosition
       }
     });
   }
 });
 
 $('input.number').stepper({
   min: 1
 });
 
 if ("mask" in $(window)) {

   $('.mask').each(
       function() {
         var mask = $(this).attr('data-mask'),
         reverse = $(this).attr('data-reverse') ? true : false;
         if(mask=="CelSP"){
           $(this).mask(CelSP, {onKeyPress: function(phone, e, currentField, options){
             $(currentField).mask(CelSP(phone), options);
           }});
           return;
         }
         $(this).mask(mask, {
           reverse : reverse
         });
       });
 }
 
 $('.cep-trigger').on('change', function(e){
   if($(this).val()){
     var cep = $(this).val();
     $.ajax({
       url: "ajax/cep.json",
       dataType: "JSON",
       type: "GET",
       data:{
         cep: cep
       },
       beforeSend: function(){
         $('body').css('cursor', 'progress');
         $('input').prop('disabled', true);
       },
       complete: function(){
         $('body').css('cursor', '');
         $('input').prop('disabled', false);
       },
       success: function(data){
         var address = data.tipo_logradouro+" "+data.logradouro;
         $('#address').val(address);
         $('#city').val(data.cidade);
         $('#state option').prop('selected', false);
         $('#state option[value="'+data.uf+'"]').prop('selected', true);
         $('#state').trigger('change');
         $('#neighborhood').val(data.bairro);
       }
     });
   }
 });
 
 $('.order-emailtrigger').on('change', function(e){
   if($(this).val()){
     var email = $(this).val();
     $.ajax({
       url: "ajax/usersearch.json",
       dataType: "JSON",
       type: "GET",
       data: {
         email: email
       },
       beforeSend: function(){
         $('body').css('cursor', 'progress');
         $('input').prop('disabled', true);
       },
       complete: function(){
         $('body').css('cursor', '');
         $('input').prop('disabled', false);
       },
       success: function(data){
         if(data.result!="NOT_FOUND"){
           var data = data.result;
           $('#name').val(data.name);
           $('#email').val(data.email);
           $('#address').val(data.address);
           $('#number').val(data.numer);
           $('#neighborhood').val(data.neighborhood);
           $('#city').val(data.city);
           $('#state option').prop('selected', false);
           $('#state option[value="'+data.state+'"]').prop('selected', true);
           $('#state').trigger('change');
         }
       }
     })
   }
 });
 
 $.getJSON('ajax/rss.json', function(data){
   $.each(data, function(i, obj){
     var element = $('<li></li>'),
         link = $('<a></a>');
     link.attr('href', obj.permalink).attr('target', '_blank').html(obj.title);
     element.append(link).prependTo($('#rssfeeds'));
   });
 });
 
 
 
 $('textarea[maxlength]').each(function(i, obj){
   var maxLength = $(this).attr('maxlength');
   var badge = $('<span class="badge pull-right"></span>').html(maxLength).insertBefore(obj);
   $(obj).bind('keyup', function(){
     var length = $(this).val().length,
         charsLeft = maxLength-length;
     badge.html(charsLeft);
     if(charsLeft < 10){
       badge.addClass('alert-danger');
     }else{
       badge.removeClass('alert-danger');
     }
     if(length>maxLength){
       var subtext = $(obj).val().substr(0, maxLength);
       $(obj).text(subtext);
       $('*[type=submit]').prop('disabled', true);
     }else{
       $('*[type=submit]').prop('disabled', false);
     }
   });
 });
});