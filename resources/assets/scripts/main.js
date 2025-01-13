import $ from 'jquery';
import '@popperjs/core';
import 'bootstrap/dist/js/bootstrap';
import "select2/dist/js/select2.min.js";
import { App } from './parts/app.js'
import { Plugins } from './parts/plugins.js'
import { Parts } from './parts/parts.js'
import { Privacy } from './parts/privacy.js'; 
import { Truncate } from './parts/truncate.js';
import { Video } from './parts/video.js';
import { Header } from './parts/header.js';
import { Filter } from './parts/filter.js';
import Aos from 'aos';
// export for others scripts to use
window.$ = $;
window.jQuery = jQuery;

$(function () {

  window.windowWidth = $(window).width();
  window.windowHeight = $(window).height();

  window.isiPhone = navigator.userAgent.toLowerCase().indexOf('iphone');
  window.isiPad = navigator.userAgent.toLowerCase().indexOf('ipad');
  window.isiPod = navigator.userAgent.toLowerCase().indexOf('ipod');

  //Functions List Below

  window.app = new App();
  window.app.init();

  window.plugins = new Plugins();
  window.plugins.init();

  window.parts = new Parts();
  window.parts.init();

  window.privacy = new Privacy();
  window.privacy.init();

  window.truncate = new Truncate();
  window.truncate.init();


  window.video = new Video();
  window.video.init();


  window.header = new Header();
  window.header.init();

  window.filter = new Filter();
  window.filter.init();

});

// ===========================================================================
jQuery(document).ready(function ($) {
Aos.init({
  once: true,
});
});