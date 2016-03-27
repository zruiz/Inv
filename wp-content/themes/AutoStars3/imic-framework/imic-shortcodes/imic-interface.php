<?php
// Require config
require_once('imic-config.php');
$icon_list = '';
$icon_list .= '<li><i class="fa-glass"></i><span class="icon-name">fa-glass</span></li><li><i class="fa-music"></i><span class="icon-name">fa-music</span></li><li><i class="fa-search"></i><span class="icon-name">fa-search</span></li><li><i class="fa-envelope-o"></i><span class="icon-name">fa-envelope-o</span></li><li><i class="fa-heart"></i><span class="icon-name">fa-heart</span></li><li><i class="fa-star"></i><span class="icon-name">fa-star</span></li><li><i class="fa-star-o"></i><span class="icon-name">fa-star-o</span></li><li><i class="fa-user"></i><span class="icon-name">fa-user</span></li><li><i class="fa-film"></i><span class="icon-name">fa-film</span></li><li><i class="fa-th-large"></i><span class="icon-name">fa-th-large</span></li><li><i class="fa-th"></i><span class="icon-name">fa-th</span></li><li><i class="fa-th-list"></i><span class="icon-name">fa-th-list</span></li><li><i class="fa-check"></i><span class="icon-name">fa-check</span></li><li><i class="fa-times"></i><span class="icon-name">fa-times</span></li><li><i class="fa-search-plus"></i><span class="icon-name">fa-search-plus</span></li><li><i class="fa-search-minus"></i><span class="icon-name">fa-search-minus</span></li><li><i class="fa-power-off"></i><span class="icon-name">fa-power-off</span></li><li><i class="fa-signal"></i><span class="icon-name">fa-signal</span></li><li><i class="fa-cog"></i><span class="icon-name">fa-cog</span></li><li><i class="fa-trash-o"></i><span class="icon-name">fa-trash-o</span></li><li><i class="fa-home"></i><span class="icon-name">fa-home</span></li><li><i class="fa-file-o"></i><span class="icon-name">fa-file-o</span></li><li><i class="fa-clock-o"></i><span class="icon-name">fa-clock-o</span></li><li><i class="fa-road"></i><span class="icon-name">fa-road</span></li><li><i class="fa-download"></i><span class="icon-name">fa-download</span></li><li><i class="fa-arrow-circle-o-down"></i><span class="icon-name">fa-arrow-circle-o-down</span></li><li><i class="fa-arrow-circle-o-up"></i><span class="icon-name">fa-arrow-circle-o-up</span></li><li><i class="fa-inbox"></i><span class="icon-name">fa-inbox</span></li><li><i class="fa-play-circle-o"></i><span class="icon-name">fa-play-circle-o</span></li><li><i class="fa-repeat"></i><span class="icon-name">fa-repeat</span></li><li><i class="fa-refresh"></i><span class="icon-name">fa-refresh</span></li><li><i class="fa-list-alt"></i><span class="icon-name">fa-list-alt</span></li><li><i class="fa-lock"></i><span class="icon-name">fa-lock</span></li><li><i class="fa-flag"></i><span class="icon-name">fa-flag</span></li><li><i class="fa-headphones"></i><span class="icon-name">fa-headphones</span></li><li><i class="fa-volume-off"></i><span class="icon-name">fa-volume-off</span></li><li><i class="fa-volume-down"></i><span class="icon-name">fa-volume-down</span></li><li><i class="fa-volume-up"></i><span class="icon-name">fa-volume-up</span></li><li><i class="fa-qrcode"></i><span class="icon-name">fa-qrcode</span></li><li><i class="fa-barcode"></i><span class="icon-name">fa-barcode</span></li><li><i class="fa-tag"></i><span class="icon-name">fa-tag</span></li><li><i class="fa-tags"></i><span class="icon-name">fa-tags</span></li><li><i class="fa-book"></i><span class="icon-name">fa-book</span></li><li><i class="fa-bookmark"></i><span class="icon-name">fa-bookmark</span></li><li><i class="fa-print"></i><span class="icon-name">fa-print</span></li><li><i class="fa-camera"></i><span class="icon-name">fa-camera</span></li><li><i class="fa-font"></i><span class="icon-name">fa-font</span></li><li><i class="fa-bold"></i><span class="icon-name">fa-bold</span></li><li><i class="fa-italic"></i><span class="icon-name">fa-italic</span></li><li><i class="fa-text-height"></i><span class="icon-name">fa-text-height</span></li><li><i class="fa-text-width"></i><span class="icon-name">fa-text-width</span></li><li><i class="fa-align-left"></i><span class="icon-name">fa-align-left</span></li><li><i class="fa-align-center"></i><span class="icon-name">fa-align-center</span></li><li><i class="fa-align-right"></i><span class="icon-name">fa-align-right</span></li><li><i class="fa-align-justify"></i><span class="icon-name">fa-align-justify</span></li><li><i class="fa-list"></i><span class="icon-name">fa-list</span></li><li><i class="fa-outdent"></i><span class="icon-name">fa-outdent</span></li><li><i class="fa-indent"></i><span class="icon-name">fa-indent</span></li><li><i class="fa-video-camera"></i><span class="icon-name">fa-video-camera</span></li><li><i class="fa-picture-o"></i><span class="icon-name">fa-picture-o</span></li><li><i class="fa-pencil"></i><span class="icon-name">fa-pencil</span></li><li><i class="fa-map-marker"></i><span class="icon-name">fa-map-marker</span></li><li><i class="fa-adjust"></i><span class="icon-name">fa-adjust</span></li><li><i class="fa-tint"></i><span class="icon-name">fa-tint</span></li><li><i class="fa-pencil-square-o"></i><span class="icon-name">fa-pencil-square-o</span></li><li><i class="fa-share-square-o"></i><span class="icon-name">fa-share-square-o</span></li><li><i class="fa-check-square-o"></i><span class="icon-name">fa-check-square-o</span></li><li><i class="fa-move"></i><span class="icon-name">fa-move</span></li><li><i class="fa-step-backward"></i><span class="icon-name">fa-step-backward</span></li><li><i class="fa-fast-backward"></i><span class="icon-name">fa-fast-backward</span></li><li><i class="fa-backward"></i><span class="icon-name">fa-backward</span></li><li><i class="fa-play"></i><span class="icon-name">fa-play</span></li><li><i class="fa-pause"></i><span class="icon-name">fa-pause</span></li><li><i class="fa-stop"></i><span class="icon-name">fa-stop</span></li><li><i class="fa-forward"></i><span class="icon-name">fa-forward</span></li><li><i class="fa-fast-forward"></i><span class="icon-name">fa-fast-forward</span></li><li><i class="fa-step-forward"></i><span class="icon-name">fa-step-forward</span></li><li><i class="fa-eject"></i><span class="icon-name">fa-eject</span></li><li><i class="fa-chevron-left"></i><span class="icon-name">fa-chevron-left</span></li><li><i class="fa-chevron-right"></i><span class="icon-name">fa-chevron-right</span></li><li><i class="fa-plus-circle"></i><span class="icon-name">fa-plus-circle</span></li><li><i class="fa-minus-circle"></i><span class="icon-name">fa-minus-circle</span></li><li><i class="fa-times-circle"></i><span class="icon-name">fa-times-circle</span></li><li><i class="fa-check-circle"></i><span class="icon-name">fa-check-circle</span></li><li><i class="fa-question-circle"></i><span class="icon-name">fa-question-circle</span></li><li><i class="fa-info-circle"></i><span class="icon-name">fa-info-circle</span></li><li><i class="fa-crosshairs"></i><span class="icon-name">fa-crosshairs</span></li><li><i class="fa-times-circle-o"></i><span class="icon-name">fa-times-circle-o</span></li><li><i class="fa-check-circle-o"></i><span class="icon-name">fa-check-circle-o</span></li><li><i class="fa-ban"></i><span class="icon-name">fa-ban</span></li><li><i class="fa-arrow-left"></i><span class="icon-name">fa-arrow-left</span></li><li><i class="fa-arrow-right"></i><span class="icon-name">fa-arrow-right</span></li><li><i class="fa-arrow-up"></i><span class="icon-name">fa-arrow-up</span></li><li><i class="fa-arrow-down"></i><span class="icon-name">fa-arrow-down</span></li><li><i class="fa-share"></i><span class="icon-name">fa-share</span></li><li><i class="fa-resize-full"></i><span class="icon-name">fa-resize-full</span></li><li><i class="fa-resize-small"></i><span class="icon-name">fa-resize-small</span></li><li><i class="fa-plus"></i><span class="icon-name">fa-plus</span></li><li><i class="fa-minus"></i><span class="icon-name">fa-minus</span></li><li><i class="fa-asterisk"></i><span class="icon-name">fa-asterisk</span></li><li><i class="fa-exclamation-circle"></i><span class="icon-name">fa-exclamation-circle</span></li><li><i class="fa-gift"></i><span class="icon-name">fa-gift</span></li><li><i class="fa-leaf"></i><span class="icon-name">fa-leaf</span></li><li><i class="fa-fire"></i><span class="icon-name">fa-fire</span></li><li><i class="fa-eye"></i><span class="icon-name">fa-eye</span></li><li><i class="fa-eye-slash"></i><span class="icon-name">fa-eye-slash</span></li><li><i class="fa-exclamation-triangle"></i><span class="icon-name">fa-exclamation-triangle</span></li><li><i class="fa-plane"></i><span class="icon-name">fa-plane</span></li><li><i class="fa-calendar"></i><span class="icon-name">fa-calendar</span></li><li><i class="fa-random"></i><span class="icon-name">fa-random</span></li><li><i class="fa-comment"></i><span class="icon-name">fa-comment</span></li><li><i class="fa-magnet"></i><span class="icon-name">fa-magnet</span></li><li><i class="fa-chevron-up"></i><span class="icon-name">fa-chevron-up</span></li><li><i class="fa-chevron-down"></i><span class="icon-name">fa-chevron-down</span></li><li><i class="fa-retweet"></i><span class="icon-name">fa-retweet</span></li><li><i class="fa-shopping-cart"></i><span class="icon-name">fa-shopping-cart</span></li><li><i class="fa-folder"></i><span class="icon-name">fa-folder</span></li><li><i class="fa-folder-open"></i><span class="icon-name">fa-folder-open</span></li><li><i class="fa-resize-vertical"></i><span class="icon-name">fa-resize-vertical</span></li><li><i class="fa-resize-horizontal"></i><span class="icon-name">fa-resize-horizontal</span></li><li><i class="fa-bar-chart-o"></i><span class="icon-name">fa-bar-chart-o</span></li><li><i class="fa-twitter-square"></i><span class="icon-name">fa-twitter-square</span></li><li><i class="fa-facebook-square"></i><span class="icon-name">fa-facebook-square</span></li><li><i class="fa-camera-retro"></i><span class="icon-name">fa-camera-retro</span></li><li><i class="fa-key"></i><span class="icon-name">fa-key</span></li><li><i class="fa-cogs"></i><span class="icon-name">fa-cogs</span></li><li><i class="fa-comments"></i><span class="icon-name">fa-comments</span></li><li><i class="fa-thumbs-o-up"></i><span class="icon-name">fa-thumbs-o-up</span></li><li><i class="fa-thumbs-o-down"></i><span class="icon-name">fa-thumbs-o-down</span></li><li><i class="fa-star-half"></i><span class="icon-name">fa-star-half</span></li><li><i class="fa-heart-o"></i><span class="icon-name">fa-heart-o</span></li><li><i class="fa-sign-out"></i><span class="icon-name">fa-sign-out</span></li><li><i class="fa-linkedin-square"></i><span class="icon-name">fa-linkedin-square</span></li><li><i class="fa-thumb-tack"></i><span class="icon-name">fa-thumb-tack</span></li><li><i class="fa-external-link"></i><span class="icon-name">fa-external-link</span></li><li><i class="fa-sign-in"></i><span class="icon-name">fa-sign-in</span></li><li><i class="fa-trophy"></i><span class="icon-name">fa-trophy</span></li><li><i class="fa-github-square"></i><span class="icon-name">fa-github-square</span></li><li><i class="fa-upload"></i><span class="icon-name">fa-upload</span></li><li><i class="fa-lemon-o"></i><span class="icon-name">fa-lemon-o</span></li><li><i class="fa-phone"></i><span class="icon-name">fa-phone</span></li><li><i class="fa-square-o"></i><span class="icon-name">fa-square-o</span></li><li><i class="fa-bookmark-o"></i><span class="icon-name">fa-bookmark-o</span></li><li><i class="fa-phone-square"></i><span class="icon-name">fa-phone-square</span></li><li><i class="fa-twitter"></i><span class="icon-name">fa-twitter</span></li><li><i class="fa-facebook"></i><span class="icon-name">fa-facebook</span></li><li><i class="fa-github"></i><span class="icon-name">fa-github</span></li><li><i class="fa-unlock"></i><span class="icon-name">fa-unlock</span></li><li><i class="fa-credit-card"></i><span class="icon-name">fa-credit-card</span></li><li><i class="fa-rss"></i><span class="icon-name">fa-rss</span></li><li><i class="fa-hdd-o"></i><span class="icon-name">fa-hdd-o</span></li><li><i class="fa-bullhorn"></i><span class="icon-name">fa-bullhorn</span></li><li><i class="fa-bell"></i><span class="icon-name">fa-bell</span></li><li><i class="fa-certificate"></i><span class="icon-name">fa-certificate</span></li><li><i class="fa-hand-o-right"></i><span class="icon-name">fa-hand-o-right</span></li><li><i class="fa-hand-o-left"></i><span class="icon-name">fa-hand-o-left</span></li><li><i class="fa-hand-o-up"></i><span class="icon-name">fa-hand-o-up</span></li><li><i class="fa-hand-o-down"></i><span class="icon-name">fa-hand-o-down</span></li><li><i class="fa-arrow-circle-left"></i><span class="icon-name">fa-arrow-circle-left</span></li><li><i class="fa-arrow-circle-right"></i><span class="icon-name">fa-arrow-circle-right</span></li><li><i class="fa-arrow-circle-up"></i><span class="icon-name">fa-arrow-circle-up</span></li><li><i class="fa-arrow-circle-down"></i><span class="icon-name">fa-arrow-circle-down</span></li><li><i class="fa-globe"></i><span class="icon-name">fa-globe</span></li><li><i class="fa-wrench"></i><span class="icon-name">fa-wrench</span></li><li><i class="fa-tasks"></i><span class="icon-name">fa-tasks</span></li><li><i class="fa-filter"></i><span class="icon-name">fa-filter</span></li><li><i class="fa-briefcase"></i><span class="icon-name">fa-briefcase</span></li><li><i class="fa-fullscreen"></i><span class="icon-name">fa-fullscreen</span></li><li><i class="fa-group"></i><span class="icon-name">fa-group</span></li><li><i class="fa-link"></i><span class="icon-name">fa-link</span></li><li><i class="fa-cloud"></i><span class="icon-name">fa-cloud</span></li><li><i class="fa-flask"></i><span class="icon-name">fa-flask</span></li><li><i class="fa-scissors"></i><span class="icon-name">fa-scissors</span></li><li><i class="fa-files-o"></i><span class="icon-name">fa-files-o</span></li><li><i class="fa-paperclip"></i><span class="icon-name">fa-paperclip</span></li><li><i class="fa-floppy-o"></i><span class="icon-name">fa-floppy-o</span></li><li><i class="fa-square"></i><span class="icon-name">fa-square</span></li><li><i class="fa-reorder"></i><span class="icon-name">fa-reorder</span></li><li><i class="fa-list-ul"></i><span class="icon-name">fa-list-ul</span></li><li><i class="fa-list-ol"></i><span class="icon-name">fa-list-ol</span></li><li><i class="fa-strikethrough"></i><span class="icon-name">fa-strikethrough</span></li><li><i class="fa-underline"></i><span class="icon-name">fa-underline</span></li><li><i class="fa-table"></i><span class="icon-name">fa-table</span></li><li><i class="fa-magic"></i><span class="icon-name">fa-magic</span></li><li><i class="fa-truck"></i><span class="icon-name">fa-truck</span></li><li><i class="fa-pinterest"></i><span class="icon-name">fa-pinterest</span></li><li><i class="fa-pinterest-square"></i><span class="icon-name">fa-pinterest-square</span></li><li><i class="fa-google-plus-square"></i><span class="icon-name">fa-google-plus-square</span></li><li><i class="fa-google-plus"></i><span class="icon-name">fa-google-plus</span></li><li><i class="fa-money"></i><span class="icon-name">fa-money</span></li><li><i class="fa-caret-down"></i><span class="icon-name">fa-caret-down</span></li><li><i class="fa-caret-up"></i><span class="icon-name">fa-caret-up</span></li><li><i class="fa-caret-left"></i><span class="icon-name">fa-caret-left</span></li><li><i class="fa-caret-right"></i><span class="icon-name">fa-caret-right</span></li><li><i class="fa-columns"></i><span class="icon-name">fa-columns</span></li><li><i class="fa-sort"></i><span class="icon-name">fa-sort</span></li><li><i class="fa-sort-asc"></i><span class="icon-name">fa-sort-asc</span></li><li><i class="fa-sort-desc"></i><span class="icon-name">fa-sort-desc</span></li><li><i class="fa-envelope"></i><span class="icon-name">fa-envelope</span></li><li><i class="fa-linkedin"></i><span class="icon-name">fa-linkedin</span></li><li><i class="fa-undo"></i><span class="icon-name">fa-undo</span></li><li><i class="fa-gavel"></i><span class="icon-name">fa-gavel</span></li><li><i class="fa-tachometer"></i><span class="icon-name">fa-tachometer</span></li><li><i class="fa-comment-o"></i><span class="icon-name">fa-comment-o</span></li><li><i class="fa-comments-o"></i><span class="icon-name">fa-comments-o</span></li><li><i class="fa-bolt"></i><span class="icon-name">fa-bolt</span></li><li><i class="fa-sitemap"></i><span class="icon-name">fa-sitemap</span></li><li><i class="fa-umbrella"></i><span class="icon-name">fa-umbrella</span></li><li><i class="fa-clipboard"></i><span class="icon-name">fa-clipboard</span></li><li><i class="fa-lightbulb-o"></i><span class="icon-name">fa-lightbulb-o</span></li><li><i class="fa-exchange"></i><span class="icon-name">fa-exchange</span></li><li><i class="fa-cloud-download"></i><span class="icon-name">fa-cloud-download</span></li><li><i class="fa-cloud-upload"></i><span class="icon-name">fa-cloud-upload</span></li><li><i class="fa-user-md"></i><span class="icon-name">fa-user-md</span></li><li><i class="fa-stethoscope"></i><span class="icon-name">fa-stethoscope</span></li><li><i class="fa-suitcase"></i><span class="icon-name">fa-suitcase</span></li><li><i class="fa-bell-o"></i><span class="icon-name">fa-bell-o</span></li><li><i class="fa-coffee"></i><span class="icon-name">fa-coffee</span></li><li><i class="fa-cutlery"></i><span class="icon-name">fa-cutlery</span></li><li><i class="fa-file-text-o"></i><span class="icon-name">fa-file-text-o</span></li><li><i class="fa-building"></i><span class="icon-name">fa-building</span></li><li><i class="fa-hospital"></i><span class="icon-name">fa-hospital</span></li><li><i class="fa-ambulance"></i><span class="icon-name">fa-ambulance</span></li><li><i class="fa-medkit"></i><span class="icon-name">fa-medkit</span></li><li><i class="fa-fighter-jet"></i><span class="icon-name">fa-fighter-jet</span></li><li><i class="fa-beer"></i><span class="icon-name">fa-beer</span></li><li><i class="fa-h-square"></i><span class="icon-name">fa-h-square</span></li><li><i class="fa-plus-square"></i><span class="icon-name">fa-plus-square</span></li><li><i class="fa-angle-double-left"></i><span class="icon-name">fa-angle-double-left</span></li><li><i class="fa-angle-double-right"></i><span class="icon-name">fa-angle-double-right</span></li><li><i class="fa-angle-double-up"></i><span class="icon-name">fa-angle-double-up</span></li><li><i class="fa-angle-double-down"></i><span class="icon-name">fa-angle-double-down</span></li><li><i class="fa-angle-left"></i><span class="icon-name">fa-angle-left</span></li><li><i class="fa-angle-right"></i><span class="icon-name">fa-angle-right</span></li><li><i class="fa-angle-up"></i><span class="icon-name">fa-angle-up</span></li><li><i class="fa-angle-down"></i><span class="icon-name">fa-angle-down</span></li><li><i class="fa-desktop"></i><span class="icon-name">fa-desktop</span></li><li><i class="fa-laptop"></i><span class="icon-name">fa-laptop</span></li><li><i class="fa-tablet"></i><span class="icon-name">fa-tablet</span></li><li><i class="fa-mobile"></i><span class="icon-name">fa-mobile</span></li><li><i class="fa-circle-o"></i><span class="icon-name">fa-circle-o</span></li><li><i class="fa-quote-left"></i><span class="icon-name">fa-quote-left</span></li><li><i class="fa-quote-right"></i><span class="icon-name">fa-quote-right</span></li><li><i class="fa-spinner"></i><span class="icon-name">fa-spinner</span></li><li><i class="fa-circle"></i><span class="icon-name">fa-circle</span></li><li><i class="fa-reply"></i><span class="icon-name">fa-reply</span></li><li><i class="fa-github-alt"></i><span class="icon-name">fa-github-alt</span></li><li><i class="fa-folder-o"></i><span class="icon-name">fa-folder-o</span></li><li><i class="fa-folder-open-o"></i><span class="icon-name">fa-folder-open-o</span></li><li><i class="fa-expand-o"></i><span class="icon-name">fa-expand-o</span></li><li><i class="fa-collapse-o"></i><span class="icon-name">fa-collapse-o</span></li><li><i class="fa-smile-o"></i><span class="icon-name">fa-smile-o</span></li><li><i class="fa-frown-o"></i><span class="icon-name">fa-frown-o</span></li><li><i class="fa-meh-o"></i><span class="icon-name">fa-meh-o</span></li><li><i class="fa-gamepad"></i><span class="icon-name">fa-gamepad</span></li><li><i class="fa-keyboard-o"></i><span class="icon-name">fa-keyboard-o</span></li><li><i class="fa-flag-o"></i><span class="icon-name">fa-flag-o</span></li><li><i class="fa-flag-checkered"></i><span class="icon-name">fa-flag-checkered</span></li><li><i class="fa-terminal"></i><span class="icon-name">fa-terminal</span></li><li><i class="fa-code"></i><span class="icon-name">fa-code</span></li><li><i class="fa-reply-all"></i><span class="icon-name">fa-reply-all</span></li><li><i class="fa-mail-reply-all"></i><span class="icon-name">fa-mail-reply-all</span></li><li><i class="fa-star-half-o"></i><span class="icon-name">fa-star-half-o</span></li><li><i class="fa-location-arrow"></i><span class="icon-name">fa-location-arrow</span></li><li><i class="fa-crop"></i><span class="icon-name">fa-crop</span></li><li><i class="fa-code-fork"></i><span class="icon-name">fa-code-fork</span></li><li><i class="fa-chain-broken"></i><span class="icon-name">fa-chain-broken</span></li><li><i class="fa-question"></i><span class="icon-name">fa-question</span></li><li><i class="fa-info"></i><span class="icon-name">fa-info</span></li><li><i class="fa-exclamation"></i><span class="icon-name">fa-exclamation</span></li><li><i class="fa-superscript"></i><span class="icon-name">fa-superscript</span></li><li><i class="fa-subscript"></i><span class="icon-name">fa-subscript</span></li><li><i class="fa-eraser"></i><span class="icon-name">fa-eraser</span></li><li><i class="fa-puzzle-piece"></i><span class="icon-name">fa-puzzle-piece</span></li><li><i class="fa-microphone"></i><span class="icon-name">fa-microphone</span></li><li><i class="fa-microphone-slash"></i><span class="icon-name">fa-microphone-slash</span></li><li><i class="fa-shield"></i><span class="icon-name">fa-shield</span></li><li><i class="fa-calendar-o"></i><span class="icon-name">fa-calendar-o</span></li><li><i class="fa-fire-extinguisher"></i><span class="icon-name">fa-fire-extinguisher</span></li><li><i class="fa-rocket"></i><span class="icon-name">fa-rocket</span></li><li><i class="fa-maxcdn"></i><span class="icon-name">fa-maxcdn</span></li><li><i class="fa-chevron-circle-left"></i><span class="icon-name">fa-chevron-circle-left</span></li><li><i class="fa-chevron-circle-right"></i><span class="icon-name">fa-chevron-circle-right</span></li><li><i class="fa-chevron-circle-up"></i><span class="icon-name">fa-chevron-circle-up</span></li><li><i class="fa-chevron-circle-down"></i><span class="icon-name">fa-chevron-circle-down</span></li><li><i class="fa-html5"></i><span class="icon-name">fa-html5</span></li><li><i class="fa-css3"></i><span class="icon-name">fa-css3</span></li><li><i class="fa-anchor"></i><span class="icon-name">fa-anchor</span></li><li><i class="fa-unlock-o"></i><span class="icon-name">fa-unlock-o</span></li><li><i class="fa-bullseye"></i><span class="icon-name">fa-bullseye</span></li><li><i class="fa-ellipsis-horizontal"></i><span class="icon-name">fa-ellipsis-horizontal</span></li><li><i class="fa-ellipsis-vertical"></i><span class="icon-name">fa-ellipsis-vertical</span></li><li><i class="fa-rss-square"></i><span class="icon-name">fa-rss-square</span></li><li><i class="fa-play-circle"></i><span class="icon-name">fa-play-circle</span></li><li><i class="fa-ticket"></i><span class="icon-name">fa-ticket</span></li><li><i class="fa-minus-square"></i><span class="icon-name">fa-minus-square</span></li><li><i class="fa-minus-square-o"></i><span class="icon-name">fa-minus-square-o</span></li><li><i class="fa-level-up"></i><span class="icon-name">fa-level-up</span></li><li><i class="fa-level-down"></i><span class="icon-name">fa-level-down</span></li><li><i class="fa-check-square"></i><span class="icon-name">fa-check-square</span></li><li><i class="fa-pencil-square"></i><span class="icon-name">fa-pencil-square</span></li><li><i class="fa-external-link-square"></i><span class="icon-name">fa-external-link-square</span></li><li><i class="fa-share-square"></i><span class="icon-name">fa-share-square</span></li><li><i class="fa-compass"></i><span class="icon-name">fa-compass</span></li><li><i class="fa-caret-square-o-down"></i><span class="icon-name">fa-caret-square-o-down</span></li><li><i class="fa-caret-square-o-up"></i><span class="icon-name">fa-caret-square-o-up</span></li><li><i class="fa-caret-square-o-right"></i><span class="icon-name">fa-caret-square-o-right</span></li><li><i class="fa-eur"></i><span class="icon-name">fa-eur</span></li><li><i class="fa-gbp"></i><span class="icon-name">fa-gbp</span></li><li><i class="fa-usd"></i><span class="icon-name">fa-usd</span></li><li><i class="fa-inr"></i><span class="icon-name">fa-inr</span></li><li><i class="fa-jpy"></i><span class="icon-name">fa-jpy</span></li><li><i class="fa-rub"></i><span class="icon-name">fa-rub</span></li><li><i class="fa-krw"></i><span class="icon-name">fa-krw</span></li><li><i class="fa-btc"></i><span class="icon-name">fa-btc</span></li><li><i class="fa-file"></i><span class="icon-name">fa-file</span></li><li><i class="fa-file-text"></i><span class="icon-name">fa-file-text</span></li><li><i class="fa-sort-alpha-asc"></i><span class="icon-name">fa-sort-alpha-asc</span></li><li><i class="fa-sort-alpha-desc"></i><span class="icon-name">fa-sort-alpha-desc</span></li><li><i class="fa-sort-amount-asc"></i><span class="icon-name">fa-sort-amount-asc</span></li><li><i class="fa-sort-amount-desc"></i><span class="icon-name">fa-sort-amount-desc</span></li><li><i class="fa-sort-numeric-asc"></i><span class="icon-name">fa-sort-numeric-asc</span></li><li><i class="fa-sort-numeric-desc"></i><span class="icon-name">fa-sort-numeric-desc</span></li><li><i class="fa-thumbs-up"></i><span class="icon-name">fa-thumbs-up</span></li><li><i class="fa-thumbs-down"></i><span class="icon-name">fa-thumbs-down</span></li><li><i class="fa-youtube-square"></i><span class="icon-name">fa-youtube-square</span></li><li><i class="fa-youtube"></i><span class="icon-name">fa-youtube</span></li><li><i class="fa-xing"></i><span class="icon-name">fa-xing</span></li><li><i class="fa-xing-square"></i><span class="icon-name">fa-xing-square</span></li><li><i class="fa-youtube-play"></i><span class="icon-name">fa-youtube-play</span></li><li><i class="fa-dropbox"></i><span class="icon-name">fa-dropbox</span></li><li><i class="fa-stack-overflow"></i><span class="icon-name">fa-stack-overflow</span></li><li><i class="fa-instagram"></i><span class="icon-name">fa-instagram</span></li><li><i class="fa-flickr"></i><span class="icon-name">fa-flickr</span></li><li><i class="fa-adn"></i><span class="icon-name">fa-adn</span></li><li><i class="fa-bitbucket"></i><span class="icon-name">fa-bitbucket</span></li><li><i class="fa-bitbucket-square"></i><span class="icon-name">fa-bitbucket-square</span></li><li><i class="fa-tumblr"></i><span class="icon-name">fa-tumblr</span></li><li><i class="fa-tumblr-square"></i><span class="icon-name">fa-tumblr-square</span></li><li><i class="fa-long-arrow-down"></i><span class="icon-name">fa-long-arrow-down</span></li><li><i class="fa-long-arrow-up"></i><span class="icon-name">fa-long-arrow-up</span></li><li><i class="fa-long-arrow-left"></i><span class="icon-name">fa-long-arrow-left</span></li><li><i class="fa-long-arrow-right"></i><span class="icon-name">fa-long-arrow-right</span></li><li><i class="fa-apple"></i><span class="icon-name">fa-apple</span></li><li><i class="fa-windows"></i><span class="icon-name">fa-windows</span></li><li><i class="fa-android"></i><span class="icon-name">fa-android</span></li><li><i class="fa-linux"></i><span class="icon-name">fa-linux</span></li><li><i class="fa-dribbble"></i><span class="icon-name">fa-dribbble</span></li><li><i class="fa-skype"></i><span class="icon-name">fa-skype</span></li><li><i class="fa-foursquare"></i><span class="icon-name">fa-foursquare</span></li><li><i class="fa-trello"></i><span class="icon-name">fa-trello</span></li><li><i class="fa-female"></i><span class="icon-name">fa-female</span></li><li><i class="fa-male"></i><span class="icon-name">fa-male</span></li><li><i class="fa-gittip"></i><span class="icon-name">fa-gittip</span></li><li><i class="fa-sun-o"></i><span class="icon-name">fa-sun-o</span></li><li><i class="fa-moon-o"></i><span class="icon-name">fa-moon-o</span></li><li><i class="fa-archive"></i><span class="icon-name">fa-archive</span></li><li><i class="fa-bug"></i><span class="icon-name">fa-bug</span></li><li><i class="fa-vk"></i><span class="icon-name">fa-vk</span></li><li><i class="fa-weibo"></i><span class="icon-name">fa-weibo</span></li><li><i class="fa-renren"></i><span class="icon-name">fa-renren</span></li><li><i class="fa-pagelines"></i><span class="icon-name">fa-pagelines</span></li><li><i class="fa-stack-exchange"></i><span class="icon-name">fa-stack-exchange</span></li><li><i class="fa-arrow-circle-o-right"></i><span class="icon-name">fa-arrow-circle-o-right</span></li><li><i class="fa-arrow-circle-o-left"></i><span class="icon-name">fa-arrow-circle-o-left</span></li><li><i class="fa-caret-square-o-left"></i><span class="icon-name">fa-caret-square-o-left</span></li><li><i class="fa-dot-circle-o"></i><span class="icon-name">fa-dot-circle-o</span></li><li><i class="fa-wheelchair"></i><span class="icon-name">fa-wheelchair</span></li><li><i class="fa-vimeo-square"></i><span class="icon-name">fa-vimeo-square</span></li><li><i class="fa-try"></i><span class="icon-name">fa-try</span></li>';
$line_icons = "";
$line_icons = '<li><i class="icon-boat"></i><span class="icon-name">icon-boat</span></li><li><i class="icon-booknote"></i><span class="icon-name">icon-booknote</span></li><li><i class="icon-booknote-add"></i><span class="icon-name">icon-booknote-add</span></li><li><i class="icon-booknote-remove"></i><span class="icon-name">icon-booknote-remove</span></li><li><i class="icon-camera-2"></i><span class="icon-name">icon-camera-2</span></li><li><i class="icon-cloud-check"></i><span class="icon-name">icon-cloud-check</span></li><li><i class="icon-cloud-delete"></i><span class="icon-name">icon-cloud-delete</span></li><li><i class="icon-cloud-download"></i><span class="icon-name">icon-cloud-download</span></li><li><i class="icon-cloud-upload"></i><span class="icon-name">icon-cloud-upload</span></li><li><i class="icon-cloudy"></i><span class="icon-name">icon-cloudy</span></li><li><i class="icon-cocktail"></i><span class="icon-name">icon-cocktail</span></li><li><i class="icon-coffee"></i><span class="icon-name">icon-coffee</span></li><li><i class="icon-compass"></i><span class="icon-name">icon-compass</span></li><li><i class="icon-compress"></i><span class="icon-name">icon-compress</span></li><li><i class="icon-cutlery"></i><span class="icon-name">icon-cutlery</span></li><li><i class="icon-delete"></i><span class="icon-name">icon-delete</span></li><li><i class="icon-delete-folder"></i><span class="icon-name">icon-delete-folder</span></li><li><i class="icon-dialogue-add"></i><span class="icon-name">icon-dialogue-add</span></li><li><i class="icon-dialogue-delete"></i><span class="icon-name">icon-dialogue-delete</span></li><li><i class="icon-dialogue-happy"></i><span class="icon-name">icon-dialogue-happy</span></li><li><i class="icon-dialogue-sad"></i><span class="icon-name">icon-dialogue-sad</span></li><li><i class="icon-dialogue-text"></i><span class="icon-name">icon-dialogue-text</span></li><li><i class="icon-dialogue-think"></i><span class="icon-name">icon-dialogue-think</span></li><li><i class="icon-diamond"></i><span class="icon-name">icon-diamond</span></li><li><i class="icon-dish-fork"></i><span class="icon-name">icon-dish-fork</span></li><li><i class="icon-dish-spoon"></i><span class="icon-name">icon-dish-spoon</span></li><li><i class="icon-download"></i><span class="icon-name">icon-download</span></li><li><i class="icon-download-folder"></i><span class="icon-name">icon-download-folder</span></li><li><i class="icon-expand"></i><span class="icon-name">icon-expand</span></li><li><i class="icon-eye"></i><span class="icon-name">icon-eye</span></li><li><i class="icon-fast-food"></i><span class="icon-name">icon-fast-food</span></li><li><i class="icon-flag"></i><span class="icon-name">icon-flag</span></li><li><i class="icon-folder"></i><span class="icon-name">icon-folder</span></li><li><i class="icon-geolocalizator"></i><span class="icon-name">icon-geolocalizator</span></li><li><i class="icon-globe"></i><span class="icon-name">icon-globe</span></li><li><i class="icon-graph"></i><span class="icon-name">icon-graph</span></li><li><i class="icon-graph-descending"></i><span class="icon-name">icon-graph-descending</span></li><li><i class="icon-graph-rising"></i><span class="icon-name">icon-graph-rising</span></li><li><i class="icon-hammer"></i><span class="icon-name">icon-hammer</span></li><li><i class="icon-happy-drop"></i><span class="icon-name">icon-happy-drop</span></li><li><i class="icon-headphones"></i><span class="icon-name">icon-headphones</span></li><li><i class="icon-heart"></i><span class="icon-name">icon-heart</span></li><li><i class="icon-heart-broken"></i><span class="icon-name">icon-heart-broken</span></li><li><i class="icon-home"></i><span class="icon-name">icon-home</span></li><li><i class="icon-hourglass"></i><span class="icon-name">icon-hourglass</span></li><li><i class="icon-image"></i><span class="icon-name">icon-image</span></li><li><i class="icon-key"></i><span class="icon-name">icon-key</span></li><li><i class="icon-life-buoy"></i><span class="icon-name">icon-life-buoy</span></li><li><i class="icon-list"></i><span class="icon-name">icon-list</span></li><li><i class="icon-lock-closed"></i><span class="icon-name">icon-lock-closed</span></li><li><i class="icon-lock-open"></i><span class="icon-name">icon-lock-open</span></li><li><i class="icon-loudspeaker"></i><span class="icon-name">icon-loudspeaker</span></li><li><i class="icon-magnifier"></i><span class="icon-name">icon-magnifier</span></li><li><i class="icon-magnifier-minus"></i><span class="icon-name">icon-magnifier-minus</span></li><li><i class="icon-magnifier-plus"></i><span class="icon-name">icon-magnifier-plus</span></li><li><i class="icon-mail"></i><span class="icon-name">icon-mail</span></li><li><i class="icon-mail-open"></i><span class="icon-name">icon-mail-open</span></li><li><i class="icon-map"></i><span class="icon-name">icon-map</span></li><li><i class="icon-medical-case"></i><span class="icon-name">icon-medical-case</span></li><li><i class="icon-microphone-1"></i><span class="icon-name">icon-microphone-1</span></li><li><i class="icon-microphone-2"></i><span class="icon-name">icon-microphone-2</span></li><li><i class="icon-minus"></i><span class="icon-name">icon-minus</span></li><li><i class="icon-multiple-image"></i><span class="icon-name">icon-multiple-image</span></li><li><i class="icon-music-back"></i><span class="icon-name">icon-music-back</span></li><li><i class="icon-music-backtoend"></i><span class="icon-name">icon-music-backtoend</span></li><li><i class="icon-music-eject"></i><span class="icon-name">icon-music-eject</span></li><li><i class="icon-music-forward"></i><span class="icon-name">icon-music-forward</span></li><li><i class="icon-music-forwardtoend"></i><span class="icon-name">icon-music-forwardtoend</span></li><li><i class="icon-music-pause"></i><span class="icon-name">icon-music-pause</span></li><li><i class="icon-music-play"></i><span class="icon-name">icon-music-play</span></li><li><i class="icon-music-random"></i><span class="icon-name">icon-music-random</span></li><li><i class="icon-music-repeat"></i><span class="icon-name">icon-music-repeat</span></li><li><i class="icon-music-stop"></i><span class="icon-name">icon-music-stop</span></li><li><i class="icon-musical-note"></i><span class="icon-name">icon-musical-note</span></li><li><i class="icon-musical-note-2"></i><span class="icon-name">icon-musical-note-2</span></li><li><i class="icon-old-video-cam"></i><span class="icon-name">icon-old-video-cam</span></li><li><i class="icon-paper-pen"></i><span class="icon-name">icon-paper-pen</span></li><li><i class="icon-paper-pencil"></i><span class="icon-name">icon-paper-pencil</span></li><li><i class="icon-paper-sheet"></i><span class="icon-name">icon-paper-sheet</span></li><li><i class="icon-pen-pencil-ruler"></i><span class="icon-name">icon-pen-pencil-ruler</span></li><li><i class="icon-pencil"></i><span class="icon-name">icon-pencil</span></li><li><i class="icon-pencil-ruler"></i><span class="icon-name">icon-pencil-ruler</span></li><li><i class="icon-plus"></i><span class="icon-name">icon-plus</span></li><li><i class="icon-portable-pc"></i><span class="icon-name">icon-portable-pc</span></li><li><i class="icon-pricetag"></i><span class="icon-name">icon-pricetag</span></li><li><i class="icon-printer"></i><span class="icon-name">icon-printer</span></li><li><i class="icon-profile"></i><span class="icon-name">icon-profile</span></li><li><i class="icon-profile-add"></i><span class="icon-name">icon-profile-add</span></li><li><i class="icon-profile-remove"></i><span class="icon-name">icon-profile-remove</span></li><li><i class="icon-rainy"></i><span class="icon-name">icon-rainy</span></li><li><i class="icon-rotate"></i><span class="icon-name">icon-rotate</span></li><li><i class="icon-setting-1"></i><span class="icon-name">icon-setting-1</span></li><li><i class="icon-setting-2"></i><span class="icon-name">icon-setting-2</span></li><li><i class="icon-share"></i><span class="icon-name">icon-share</span></li><li><i class="icon-shield-down"></i><span class="icon-name">icon-shield-down</span></li><li><i class="icon-shield-left"></i><span class="icon-name">icon-shield-left</span></li><li><i class="icon-shield-right"></i><span class="icon-name">icon-shield-right</span></li><li><i class="icon-shield-up"></i><span class="icon-name">icon-shield-up</span></li><li><i class="icon-shopping-cart"></i><span class="icon-name">icon-shopping-cart</span></li><li><i class="icon-shopping-cart-content"></i><span class="icon-name">icon-shopping-cart-content</span></li><li><i class="icon-sinth"></i><span class="icon-name">icon-sinth</span></li><li><i class="icon-smartphone"></i><span class="icon-name">icon-smartphone</span></li><li><i class="icon-spread"></i><span class="icon-name">icon-spread</span></li><li><i class="icon-squares"></i><span class="icon-name">icon-squares</span></li><li><i class="icon-stormy"></i><span class="icon-name">icon-stormy</span></li><li><i class="icon-sunny"></i><span class="icon-name">icon-sunny</span></li><li><i class="icon-tablet"></i><span class="icon-name">icon-tablet</span></li><li><i class="icon-three-stripes-horiz"></i><span class="icon-name">icon-three-stripes-horiz</span></li><li><i class="icon-three-stripes-vert"></i><span class="icon-name">icon-three-stripes-vert</span></li><li><i class="icon-ticket"></i><span class="icon-name">icon-ticket</span></li><li><i class="icon-todolist"></i><span class="icon-name">icon-todolist</span></li><li><i class="icon-todolist-add"></i><span class="icon-name">icon-todolist-add</span></li><li><i class="icon-todolist-check"></i><span class="icon-name">icon-todolist-check</span></li><li><i class="icon-trash-bin"></i><span class="icon-name">icon-trash-bin</span></li><li><i class="icon-tshirt"></i><span class="icon-name">icon-tshirt</span></li><li><i class="icon-tv-monitor"></i><span class="icon-name">icon-tv-monitor</span></li><li><i class="icon-umbrella"></i><span class="icon-name">icon-umbrella</span></li><li><i class="icon-upload"></i><span class="icon-name">icon-upload</span></li><li><i class="icon-upload-folder"></i><span class="icon-name">icon-upload-folder</span></li><li><i class="icon-variable"></i><span class="icon-name">icon-variable</span></li><li><i class="icon-video-cam"></i><span class="icon-name">icon-video-cam</span></li><li><i class="icon-volume-higher"></i><span class="icon-name">icon-volume-higher</span></li><li><i class="icon-volume-lower"></i><span class="icon-name">icon-volume-lower</span></li><li><i class="icon-volume-off"></i><span class="icon-name">icon-volume-off</span></li><li><i class="icon-watch"></i><span class="icon-name">icon-watch</span></li><li><i class="icon-waterfall"></i><span class="icon-name">icon-waterfall</span></li><li><i class="icon-website-1"></i><span class="icon-name">icon-website-1</span></li><li><i class="icon-website-2"></i><span class="icon-name">icon-website-2</span></li><li><i class="icon-wine"></i><span class="icon-name">icon-wine</span></li><li><i class="icon-calendar"></i><span class="icon-name">icon-calendar</span></li><li><i class="icon-alarm-clock"></i><span class="icon-name">icon-alarm-clock</span></li><li><i class="icon-add-folder"></i><span class="icon-name">icon-add-folder</span></li><li><i class="icon-accelerator"></i><span class="icon-name">icon-accelerator</span></li><li><i class="icon-agenda"></i><span class="icon-name">icon-agenda</span></li><li><i class="icon-arrow-left"></i><span class="icon-name">icon-arrow-left</span></li><li><i class="icon-arrow-down"></i><span class="icon-name">icon-arrow-down</span></li><li><i class="icon-battery-1"></i><span class="icon-name">icon-battery-1</span></li><li><i class="icon-case"></i><span class="icon-name">icon-case</span></li><li><i class="icon-arrow-up"></i><span class="icon-name">icon-arrow-up</span></li><li><i class="icon-arrow-right"></i><span class="icon-name">icon-arrow-right</span></li><li><i class="icon-case-2"></i><span class="icon-name">icon-case-2</span></li><li><i class="icon-cd"></i><span class="icon-name">icon-cd</span></li><li><i class="icon-battery-2"></i><span class="icon-name">icon-battery-2</span></li><li><i class="icon-battery-3"></i><span class="icon-name">icon-battery-3</span></li><li><i class="icon-check"></i><span class="icon-name">icon-check</span></li><li><i class="icon-battery-4"></i><span class="icon-name">icon-battery-4</span></li><li><i class="icon-chronometer"></i><span class="icon-name">icon-chronometer</span></li><li><i class="icon-clock"></i><span class="icon-name">icon-clock</span></li><li><i class="icon-blackboard-graph"></i><span class="icon-name">icon-blackboard-graph</span></li>';
?>
<!-- IMIC Framework Shortcode Panel -->
<!-- OPEN html -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <!-- OPEN head -->
    <head>
        <!-- Title & Meta -->
        <title><?php _e('IMIC Framework Shortcodes', 'imic-framework-admin'); ?></title>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
        <!-- LOAD scripts -->
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/jquery/jquery.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/imic-framework/imic-shortcodes/imic.shortcodes.js?ver=3"></script>
		<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/imic-framework/imic-shortcodes/imic.shortcode.embed.js?v=1.5"></script>
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <base target="_self" />
        <link href="<?php echo get_template_directory_uri() ?>/css/font-awesome.min.css?ver=2.0.1" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri() ?>/css/line-icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri() ?>/imic-framework/imic-shortcodes/imic-base.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo get_template_directory_uri() ?>/imic-framework/imic-shortcodes/imic-shortcodes-style.css" rel="stylesheet" type="text/css" />
        <!-- CLOSE head -->
    </head>
    <!-- OPEN body -->
    <body onLoad="tinyMCEPopup.executeOnLoad('init();');
            document.body.style.display = '';" id="link" >
        <!-- OPEN imicframework_shortcode_form -->
        <form name="imicframework_shortcode_form" action="#">
            <!-- OPEN #shortcode_wrap -->
            <div id="shortcode_wrap">
                <!-- CLOSE #shortcode_panel -->
                <div id="shortcode_panel" class="current">
                    <fieldset>
                        <h4><?php echo esc_attr_e('Select a shortcode', 'imic-framework-admin'); ?></h4>
                        <div class="option">
                            <label for="shortcode-select"><?php echo esc_attr_e('Shortcode', 'imic-framework-admin'); ?></label>
                            <select id="shortcode-select" name="shortcode-select">
                                <option value="0"></option>
                                <option value="shortcode-accordion"><?php echo esc_attr_e('Accordions', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-staff"><?php echo esc_attr_e('Staff', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-dealers"><?php echo esc_attr_e('Dealers', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-browse-listing"><?php echo esc_attr_e('Browse Listing', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-buttons"><?php echo esc_attr_e('Button', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-columns"><?php echo esc_attr_e('Columns', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-counters"><?php echo esc_attr_e('Counters', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-form"><?php echo esc_attr_e('Form', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-gmap"><?php echo esc_attr_e('Google Map', 'imic-framework-admin'); ?></option>
                                <!--<option value="shortcode-calendar"><?php echo esc_attr_e('Calendar', 'imic-framework-admin'); ?></option>-->
                                <option value="shortcode-icons"><?php echo esc_attr_e('Icons', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-icons-box"><?php echo esc_attr_e('Icons Box', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-lists"><?php echo esc_attr_e('Lists', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-listing"><?php echo esc_attr_e('Ad Listing', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-mostviewed"><?php echo esc_attr_e('Most Viewed', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-category"><?php echo esc_attr_e('Listing Categories', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-featcat"><?php echo esc_attr_e('Featured Categories', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-modal"><?php echo esc_attr_e('Modal Box', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-progressbar"><?php echo esc_attr_e('Progress Bar', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-pricing-table"><?php _e('Pricing Table', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-plan"><?php echo esc_attr_e('Plan', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-search"><?php echo esc_attr_e('Search', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-sidebar"><?php _e('Sidebar', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-tables"><?php echo esc_attr_e('Table', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-video"><?php echo esc_attr_e('Video', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-testimonial"><?php echo esc_attr_e('Testimonials', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-tooltip"><?php echo esc_attr_e('Tooltip', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-typography"><?php echo esc_attr_e('Typography', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-tabs"><?php echo esc_attr_e('Tabs', 'imic-framework-admin'); ?></option>
                                <option value="shortcode-toggle"><?php echo esc_attr_e('Toggles', 'imic-framework-admin'); ?></option>
                            </select>
                        </div>
                        <!--//////////////////////////////
                        ////	STAFF
                        //////////////////////////////-->
                        <div id="shortcode-staff">
                        <?php $g_terms = get_terms('staff-category'); ?>
                            <h5><?php echo esc_attr_e('Staff', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="staff-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="staff-title" name="staff-title" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="staff-number"><?php echo esc_attr_e('Number of Staff', 'imic-framework-admin'); ?></label>
                                <input id="staff-number" name="staff-number" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="staff-column"><?php echo esc_attr_e('Column', 'imic-framework-admin'); ?></label>
                                <select id="staff-column" name="staff-column">
                                    <option value="4"><?php echo esc_attr_e('One Third', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('One Fourth', 'imic-framework-admin'); ?></option>
                                    <option value="6"><?php echo esc_attr_e('Half', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('One Sixth', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	DEALERS
                        //////////////////////////////-->
                        <div id="shortcode-dealers">
                        <?php $dealers_role = get_terms('user-role'); ?>
                            <h5><?php echo esc_attr_e('Dealers', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="dealers-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="dealers-title" name="dealers-title" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="dealers-number"><?php echo esc_attr_e('Number of Dealers', 'imic-framework-admin'); ?></label>
                                <input id="dealers-number" name="dealers-number" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="dealers-role"><?php echo esc_attr_e('Role', 'imic-framework-admin'); ?></label>
                                <select id="dealers-role" name="dealers-role">
                                    <option value=""><?php echo esc_attr_e('All', 'imic-framework-admin'); ?></option>
                                    <?php if(!empty($dealers_role))
																		{
																			foreach($dealers_role as $role)
																			{
																				echo '<option value="'.esc_attr($role->slug).'">'.esc_attr($role->name).'</option>';
																			}
																		}
																		?>
                                </select>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	AD LISTING
                        //////////////////////////////-->
                        <div id="shortcode-listing">
                            <div class="option">
                                <label for="listing-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="listing-title" name="listing-title" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="listing-number"><?php echo esc_attr_e('Number of Listings', 'imic-framework-admin'); ?></label>
                                <input id="listing-number" name="listing-number" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="listing-cats"><?php echo esc_attr_e('Listing Categories. Enter slugs with comma "," separated.', 'imic-framework-admin'); ?></label>
                                <input id="listing-cats" name="listing-cats" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="listing-tags"><?php echo esc_attr_e('Listing Tags. Enter slug with comma "," separated.', 'imic-framework-admin'); ?></label>
                                <input id="listing-tags" name="listing-tags" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="listing-specfications"><?php echo esc_attr_e('Listing Specifications. Enter specifications value comma "," separated.', 'imic-framework-admin'); ?></label>
                                <input id="listing-specifications" name="listing-specifications" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="listing-view"><?php echo esc_attr_e('Listing View', 'imic-framework-admin'); ?></label>
                                <select id="listing-view" name="listing-view">
                                    <option value="0"><?php echo esc_attr_e('List', 'imic-framework-admin'); ?></option>
                                    <option value="1"><?php echo esc_attr_e('Grid', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('Carousel', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="listing-column"><?php echo esc_attr_e('Columns', 'imic-framework-admin'); ?></label>
                                <select id="listing-column" name="listing-column">
                                    <option value="4"><?php echo esc_attr_e('One Third', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('One Fourth', 'imic-framework-admin'); ?></option>
                                    <option value="6"><?php echo esc_attr_e('Half', 'imic-framework-admin'); ?></option>
                                    <option value="12"><?php echo esc_attr_e('Full', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('One Sixth', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                        <!-- SIDEBAR -->
                            <div id="shortcode-sidebar">
                                <h5><?php _e('Sidebar', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="sidebar-listing"><?php _e('Select Sidebar', 'imic-framework-admin'); ?></label>
                                    <select id="sidebar-listing" name="sidebar-listing">
                                        <option value=""><?php _e('Select', 'imic-framework-admin'); ?></option>
                                        <?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
                                             <option value="<?php echo ucwords( $sidebar['id'] ); ?>">
                                                      <?php echo ucwords( $sidebar['name'] ); ?>
                                             </option>
                                        <?php } ?>
                                    </select>
                                </div>
                             </div>
                        <!--//////////////////////////////
                        ////	MOST VIEWED
                        //////////////////////////////-->
                        <div id="shortcode-mostviewed">
                            <div class="option">
                                <label for="most-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="most-title" name="most-title" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="most-number"><?php echo esc_attr_e('Number of Viewed', 'imic-framework-admin'); ?></label>
                                <input id="most-number" name="most-number" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="most-view"><?php echo esc_attr_e('Type', 'imic-framework-admin'); ?></label>
                                <select id="most-view" name="most-view">
                                    <option value="1"><?php echo esc_attr_e('Recent Viewed Listing', 'imic-framework-admin'); ?></option>
                                    <!--<option value="2"><?php echo esc_attr_e('Recent Viewed Category', 'imic-framework-admin'); ?></option>-->
                                    <option value="3"><?php echo esc_attr_e('Most Viewed Listing', 'imic-framework-admin'); ?></option>
                                    <!--<option value="4"><?php echo esc_attr_e('Most Viewed Category', 'imic-framework-admin'); ?></option>-->
                                </select>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	LISTING CATEGORY
                        //////////////////////////////-->
                        <div id="shortcode-category">
                            <div class="option">
                                <label for="category-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="category-title" name="category-title" type="text" value="" />
                            </div>
                            <!--<div class="option">
                                <label for="category-cats"><?php echo esc_attr_e('Listing Categories. Enter slugs with comma "," separated.', 'imic-framework-admin'); ?></label>
                                <input id="category-cats" name="category-cats" type="text" value="" />
                            </div>-->
                            </div>
                            <!--//////////////////////////////
                        ////	FEATURED CATEGORY
                        //////////////////////////////-->
                        <div id="shortcode-featcat">
                            <div class="option">
                                <label for="featcat-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="featcat-title" name="featcat-title" type="text" value="" />
                            </div>
                            </div>
                        <!--//////////////////////////////
                        ////	SEARCH
                        //////////////////////////////-->
                        <div id="shortcode-search">
                            <h5><?php echo esc_attr_e('Search Form', 'imic-framework-admin'); ?></h5>
                            <!--<div class="option">
                                <label for="search-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="search-title" name="search-title" type="text" value="" />
                            </div>-->
                            <div class="option">
                                <label for="search-type"><?php echo esc_attr_e('Options', 'imic-framework-admin'); ?></label>
                                <select id="search-type" name="search-type">
                                    <option value="1"><?php echo esc_attr_e('Search Widget 1', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('Search Widget 2', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="search-column"><?php echo esc_attr_e('Columns', 'imic-framework-admin'); ?></label>
                                <select id="search-column" name="search-column">
                                    <option value="12"><?php echo esc_attr_e('One Column', 'imic-framework-admin'); ?></option>
                                    <option value="6"><?php echo esc_attr_e('Two Columns', 'imic-framework-admin'); ?></option>
                                    <option value="4"><?php echo esc_attr_e('Three Columns', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('Four Columns', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	TESTIMONIAL
                        //////////////////////////////-->
                        <div id="shortcode-testimonial">
                            <h5><?php echo esc_attr_e('Testimonial', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="testimonial-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="testimonial-title" name="testimonial-title" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="testimonial-number"><?php echo esc_attr_e('Number of Testimonial', 'imic-framework-admin'); ?></label>
                                <input id="testimonial-number" name="testimonial-number" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="testimonial-type"><?php echo esc_attr_e('Type', 'imic-framework-admin'); ?></label>
                                <select id="testimonial-type" name="testimonial-type">
                                    <option value="1"><?php echo esc_attr_e('One', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('Two', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	BROWSE LISTING
                        //////////////////////////////-->
                        <div id="shortcode-browse-listing">
                            <h5><?php echo esc_attr_e('Browse Listing', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="browse-listing-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="browse-listing-title" name="browse-listing-title" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="browse-listing-value"><?php echo esc_attr_e('Show Values', 'imic-framework-admin'); ?></label>
                                <select id="browse-listing-value" name="browse-listing-value">
                                    <option value="0"><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                    <option value="1"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="browse-listing-specs"><?php echo esc_attr_e('Specifications', 'imic-framework-admin'); ?></label>
                                <select id="browse-listing-specs" name="browse-listing-specs">
                                <?php $args = array( 'post_type'=>'specification', 'posts_per_page' => -1, );
										$specifications = get_posts( $args );
										print_r($specifications);
										foreach ( $specifications as $specification ) : //setup_postdata( $specification ); ?>
                                    <option value="<?php echo esc_attr($specification->ID); ?>"><?php echo get_the_title($specification->ID); ?></option>
                             	<?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                         <!--//////////////////////////////
                        ////	PLANS
                        //////////////////////////////-->
                        <?php $plan_category = get_terms('plan-category'); ?>
                        <div id="shortcode-plan">
                            <h5><?php echo esc_attr_e('Plan', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="plan-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                <input id="plan-title" name="plan-title" type="text" value="" />
                            </div>
                            <div class="option">
                                <label for="plan-number"><?php echo esc_attr_e('Number of Plan', 'imic-framework-admin'); ?></label>
                                <input id="plan-number" name="plan-number" type="text" value="" />
                            </div>
                            
                            <div class="option">
                                <label for="plan-category"><?php echo esc_attr_e('Plan Category', 'imic-framework-admin'); ?></label>
                                <select id="plan-category" name="plan-category">
                                    <option value=""><?php echo esc_attr_e('Select', 'imic-framework-admin'); ?></option>
                                    <?php if(!empty($plan_category)) { ?>
                                    <?php foreach($plan_category as $category) { ?>
                                    <option value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            
                        </div>
                        <!--//////////////////////////////
                        ////	BUTTONS
                        //////////////////////////////-->
                        <div id="shortcode-buttons">
                            <h5><?php echo esc_attr_e('Buttons', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="button-colour"><?php echo esc_attr_e('Button colour', 'imic-framework-admin'); ?></label>
                                <select id="button-colour" name="button-colour">
                                    <option value="btn-default"><?php echo esc_attr_e('Default', 'imic-framework-admin'); ?></option>
                                    <option value="btn-primary"><?php echo esc_attr_e('Primary', 'imic-framework-admin'); ?></option>
                                    <option value="btn-success"><?php echo esc_attr_e('Success', 'imic-framework-admin'); ?></option>
                                    <option value="btn-info"><?php echo esc_attr_e('Info', 'imic-framework-admin'); ?></option>
                                    <option value="btn-warning"><?php echo esc_attr_e('Warning', 'imic-framework-admin'); ?></option>
                                    <option value="btn-danger"><?php echo esc_attr_e('Danger', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="button-type"><?php echo esc_attr_e('Button type', 'imic-framework-admin'); ?></label>
                                <select id="button-type" name="button-type">
                                    <option value="enabled"><?php echo esc_attr_e('Enabled', 'imic-framework-admin'); ?></option>
                                    <option value="disabled"><?php echo esc_attr_e('Disabled', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="button-text"><?php echo esc_attr_e('Button text', 'imic-framework-admin'); ?></label>
                                <input id="button-text" name="button-text" type="text" value="<?php _e('Button text', 'imic-framework-admin'); ?>"/>
                            </div>
                            <div class="option">
                                <label for="button-url"><?php echo esc_attr_e('Button URL', 'imic-framework-admin'); ?></label>
                                <input id="button-url" name="button-url" type="text" value="http://"/>
                            </div>
                            <div class="option">
                                <label for="button-target" class="for-checkbox"><?php echo esc_attr_e('Open link in a new window?', 'imic-framework-admin'); ?></label>
                                <input id="button-target" class="checkbox" name="button-target" type="checkbox"/>
                            </div>
                            <div class="option">
                                <label for="button-size"><?php echo esc_attr_e('Button Size', 'imic-framework-admin'); ?></label>
                                <select id="button-size" name="button-size">
                                    <option value=""><?php echo esc_attr_e('Default', 'imic-framework-admin'); ?></option>
                                    <option value="btn-xs"><?php echo esc_attr_e('Extra Small', 'imic-framework-admin'); ?></option>
                                    <option value="btn-sm"><?php echo esc_attr_e('Small', 'imic-framework-admin'); ?></option>
                                    <option value="btn-lg"><?php echo esc_attr_e('Large', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="button-extraclass"><?php echo esc_attr_e('Button Extra Class', 'imic-framework-admin'); ?></label>
                                <input id="button-extraclass" name="button-extraclass" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Optional, for extra styling/custom colour control.','imic-framework-admin'); ?></a></p>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	ICONS
                        //////////////////////////////-->
                        <div id="shortcode-icons">
                            <h5><?php echo esc_attr_e('Icons', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="icon-image"><?php echo esc_attr_e('Icon image', 'imic-framework-admin'); ?></label>
                                <input id="icon-image" name="icon-image" type="text" value="" style="visibility: hidden;"/>
                                <?php echo '<ul class="font-icon-grid">'.$icon_list.'</ul>'; ?>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	VIDEO
                        //////////////////////////////-->
                        <div id="shortcode-video">
                            <h5><?php echo esc_attr_e('Video', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="video-url"><?php echo esc_attr_e('Insert Vimeo or Youtube URL', 'imic-framework-admin'); ?></label>
                                <input id="video-url" name="video-url" type="text" value=""/>
                            </div>
                            <div class="option">
                                <label for="video-width"><?php echo esc_attr_e('Video Width', 'imic-framework-admin'); ?></label>
                                <input id="video-width" name="video-width" type="text" value=""/>
                            </div>
                            <div class="option">
                                <label for="video-height"><?php echo esc_attr_e('Video Height', 'imic-framework-admin'); ?></label>
                                <input id="video-height" name="video-height" type="text" value=""/>
                            </div>
                            <div class="option">
                                    <label for="video-full"><?php echo esc_attr_e('Full Width', 'imic-framework-admin'); ?></label>
                                    <select id="video-full" name="video-full">
                                        <option value="0"><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                        <option value="1"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                        </div>
                        <!--//////////////////////////////
                        ////	GOOGLE MAP
                        //////////////////////////////-->
                        <div id="shortcode-gmap">
                            <h5><?php echo esc_attr_e('Google Map', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="map-address"><?php echo esc_attr_e('Address', 'imic-framework-admin'); ?></label>
                                <input id="map-address" name="map-address" type="text" value="" />
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	ICONS BOX
                        //////////////////////////////-->
                        <div id="shortcode-icons-box">
                            <h5><?php _e('Icons Box', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="icon-box-image"><?php echo esc_attr_e('Fonts Icon image', 'imic-framework-admin'); ?></label>
                                <input id="icon-box-image" name="icon-box-image" type="text" value="" style="visibility: hidden;"/>
                                <?php echo '<ul class="font-icon-grid">'.$icon_list.'</ul>'; ?>
                            </div>
                            <div class="option">
                                <label for="line-icon-box-image"><?php echo esc_attr_e('Icon image', 'imic-framework-admin'); ?></label>
                                <input id="line-icon-box-image" name="line-icon-box-image" type="text" value="" style="visibility: hidden;"/>
                                <?php echo '<ul class="font-icon-grid">'.$line_icons.'</ul>'; ?>
                            </div>
                            <div class="option">
                                    <label for="icon-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                    <input id="icon-title" name="icon-title" type="text" value=""/>
                                </div>
                                <div class="option">
                                    <label for="icon-description"><?php echo esc_attr_e('Description', 'imic-framework-admin'); ?></label>
                                    <input id="icon-description" name="icon-description" type="text" value=""/>
                                </div>
                                <div class="option">
                                    <label for="icon-link"><?php echo esc_attr_e('URL', 'imic-framework-admin'); ?></label>
                                    <input id="icon-link" name="icon-link" type="text" value=""/>
                                </div>
                                <div class="option">
                                    <label for="icon-type"><?php echo esc_attr_e('Select Icon Center', 'imic-framework-admin'); ?></label>
                                    <select id="icon-type" name="icon-type">
                                        <option value="ibox-center"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                        <option value=""><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="icon-outline"><?php echo esc_attr_e('Select Icon Outline', 'imic-framework-admin'); ?></label>
                                    <select id="icon-outline" name="icon-outline">
                                        <option value="ibox-outline"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                        <option value=""><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                        <option value="ibox-border"><?php echo esc_attr_e('Border', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="icon-shade"><?php echo esc_attr_e('Select Icon Shade', 'imic-framework-admin'); ?></label>
                                    <select id="icon-shade" name="icon-shade">
                                        <option value="ibox-dark"><?php echo esc_attr_e('Dark', 'imic-framework-admin'); ?></option>
                                        <option value="ibox-light"><?php echo esc_attr_e('Light', 'imic-framework-admin'); ?></option>
                                        <option value=""><?php echo esc_attr_e('Default', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="icon-effect"><?php echo esc_attr_e('Select Icon Effect', 'imic-framework-admin'); ?></label>
                                    <select id="icon-effect" name="icon-effect">
                                        <option value="ibox-effect"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                        <option value=""><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="icon-box"><?php echo esc_attr_e('Select Icon Box', 'imic-framework-admin'); ?></label>
                                    <select id="icon-box" name="icon-box">
                                        <option value=""><?php echo esc_attr_e('Rounded', 'imic-framework-admin'); ?></option>
                                        <option value="ibox-rounded"><?php echo esc_attr_e('Square', 'imic-framework-admin'); ?></option>
                                        <option value="ibox-plain"><?php echo esc_attr_e('Plain', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                            <!--<div class="option">
                                    <label for="icon-box-type"><?php echo esc_attr_e('Select Icon Box type', 'imic-framework-admin'); ?></label>
                                    <select id="icon-box-type" name="icon-box-type">
                                        <option value="with_description"><?php echo esc_attr_e('With description', 'imic-framework-admin'); ?></option>
                                        <option value="with_out_description"><?php echo esc_attr_e('With Out description', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>-->
                        </div>
                        <!--//////////////////////////////
                        ////	TYPOGRAPHY
                        //////////////////////////////-->
                        <div id="shortcode-typography">
                            <h5><?php echo esc_attr_e('Typography', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="typography-type"><?php echo esc_attr_e('Type', 'imic-framework-admin'); ?></label>
                                <select id="typography-type" name="typography-type">
                                    <option value="0"></option>
                                    <option value="typo-anchor"><?php echo esc_attr_e('Anchor Tag', 'imic-framework-admin'); ?></option>
                                    <option value="typo-div"><?php echo esc_attr_e('Div', 'imic-framework-admin'); ?></option>
                                    <option value="typo-heading"><?php echo esc_attr_e('Heading', 'imic-framework-admin'); ?></option>
                                    <option value="typo-paragraph"><?php echo esc_attr_e('Paragraph', 'imic-framework-admin'); ?></option>
                                    <option value="typo-span"><?php echo esc_attr_e('Span Tag', 'imic-framework-admin'); ?></option>
                                    <option value="typo-divider"><?php echo esc_attr_e('Divider', 'imic-framework-admin'); ?></option>
                                    <option value="typo-container"><?php echo esc_attr_e('Row', 'imic-framework-admin'); ?></option>
                                    <option value="typo-section"><?php echo esc_attr_e('Section', 'imic-framework-admin'); ?></option>
                                    <option value="typo-spacer"><?php echo esc_attr_e('Spacer', 'imic-framework-admin'); ?></option>
                                    <option value="typo-alert"><?php echo esc_attr_e('Alert Box', 'imic-framework-admin'); ?></option>
                                    <option value="typo-blockquote"><?php echo esc_attr_e('Blockquote', 'imic-framework-admin'); ?></option>
                                    <option value="typo-dropcap"><?php echo esc_attr_e('Dropcap', 'imic-framework-admin'); ?></option>
                                    <option value="typo-code"><?php echo esc_attr_e('Code', 'imic-framework-admin'); ?></option>
                                    <option value="typo-label"><?php echo esc_attr_e('Label', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <!-- ANCHOR TAG -->
                            <div id="typo-anchor">
                                <h5><?php echo esc_attr_e('Anchor Tag', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="anchor-href"><?php echo esc_attr_e('Anchor Link', 'imic-framework-admin'); ?></label>
                                    <input id="anchor-href" name="anchor-href" type="text" value=""/>
                                </div>
                                <div class="option">
                                    <label for="anchor-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="anchor-xclass" name="anchor-xclass" type="text" value=""/>
                                </div>
                            </div>
                            <div id="typo-div">
                                <h5><?php echo esc_attr_e('Div Tag', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="div-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="div-xclass" name="div-xclass" type="text" value=""/>
                                </div>
                            </div>
                            <div id="typo-spacer">
                                <h5><?php echo esc_attr_e('Spacer Tag', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="spacer-size"><?php echo esc_attr_e('Select Spacer', 'imic-framework-admin'); ?></label>
                                    <select id="spacer-size" name="spacer-size">
                                        <option value="spacer-10"><?php echo esc_attr_e('Spacer 10', 'imic-framework-admin'); ?></option>
                                        <option value="spacer-20"><?php echo esc_attr_e('Spacer 20', 'imic-framework-admin'); ?></option>
                                        <option value="spacer-39"><?php echo esc_attr_e('Spacer 30', 'imic-framework-admin'); ?></option>
                                        <option value="spacer-40"><?php echo esc_attr_e('Spacer 40', 'imic-framework-admin'); ?></option>
                                        <option value="spacer-50"><?php echo esc_attr_e('Spacer 50', 'imic-framework-admin'); ?></option>
                                        <option value="spacer-75"><?php echo esc_attr_e('Spacer 75', 'imic-framework-admin'); ?></option>
                                        <option value="spacer-100"><?php echo esc_attr_e('Spacer 100', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="spacer-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="spacer-xclass" name="spacer-xclass" type="text" value=""/>
                                </div>
                            </div>
                            <div id="typo-section">
                                <h5><?php echo esc_attr_e('Section Tag', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="section-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="section-xclass" name="section-xclass" type="text" value=""/>
                                </div>
                            </div>
                            <!-- PARAGRAPH -->
                            <div id="typo-paragraph">
                                <h5><?php echo esc_attr_e('Paragraph', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="paragraph-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="paragraph-xclass" name="paragraph-xclass" type="text" value=""/>
                                </div>
                            </div>
                            <!-- SPAN -->
                            <div id="typo-span">
                                <h5><?php echo esc_attr_e('Span Tag', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="span-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="span-xclass" name="span-xclass" type="text" value=""/>
                                </div>
                            </div>
                            <!-- DIVIDER -->
                            <div id="typo-divider">
                                <h5><?php echo esc_attr_e('Divider', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="divider-extra"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="divider-extra" name="divider-extra" type="text" value=""/>
                                </div>
                            </div>
                            <!-- HEADINGS -->
                            <div id="typo-heading">
                                <h5><?php echo esc_attr_e('Heading', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                <label for="heading-icon"><?php echo esc_attr_e('Icon image', 'imic-framework-admin'); ?></label>
                                <input id="heading-icon" name="heading-icon" type="text" value="" style="visibility: hidden;"/>
                                <?php echo '<ul class="font-icon-grid">'.$icon_list.'</ul>'; ?>
                            </div>
                            <div class="option">
                                    <label for="heading-type"><?php echo esc_attr_e('Select Heading Type', 'imic-framework-admin'); ?></label>
                                    <select id="heading-type" name="heading-type">
                                        <option value="standard"><?php echo esc_attr_e('Standard', 'imic-framework-admin'); ?></option>
                                        <option value="block"><?php _e('Block Heading', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="heading-size"><?php echo esc_attr_e('Select Heading Tag', 'imic-framework-admin'); ?></label>
                                    <select id="heading-size" name="heading-size">
                                        <option value="h1"><?php echo esc_attr_e('H1', 'imic-framework-admin'); ?></option>
                                        <option value="h2"><?php echo esc_attr_e('H2', 'imic-framework-admin'); ?></option>
                                        <option value="h3"><?php echo esc_attr_e('H3', 'imic-framework-admin'); ?></option>
                                        <option value="h4"><?php echo esc_attr_e('H4', 'imic-framework-admin'); ?></option>
                                        <option value="h5"><?php echo esc_attr_e('H5', 'imic-framework-admin'); ?></option>
                                        <option value="h6"><?php echo esc_attr_e('H6', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="heading-extra"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="heading-extra" name="heading-extra" type="text" value=""/>
                                </div>
                            </div>
                            <!-- ALERT BOX -->
                            <div id="typo-alert">
                                <h5><?php echo esc_attr_e('Alert Box', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="alert-type"><?php echo esc_attr_e('Select Alert Box type', 'imic-framework-admin'); ?></label>
                                    <select id="alert-type" name="alert-type">
                                        <option value="alert-standard"><?php echo esc_attr_e('Standard', 'imic-framework-admin'); ?></option>
                                        <option value="alert-warning"><?php echo esc_attr_e('Warning', 'imic-framework-admin'); ?></option>
                                        <option value="alert-error"><?php echo esc_attr_e('Error', 'imic-framework-admin'); ?></option>
                                        <option value="alert-info"><?php echo esc_attr_e('Info', 'imic-framework-admin'); ?></option>
                                        <option value="alert-success"><?php echo esc_attr_e('Success', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                                <div class="option">
                                    <label for="alert-close" class="for-checkbox"><?php echo esc_attr_e('Add Close Button', 'imic-framework-admin'); ?></label>
                                    <input id="alert-close" value="" class="checkbox" name="alert-close" type="checkbox"/>
                                </div>
                            </div>
                            <!-- BLOCKQUOTE -->
                            <div id="typo-blockquote">
                                <h5><?php echo esc_attr_e('Blockquote', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="blockquote-name"><?php echo esc_attr_e('Blockquote Author Name', 'imic-framework-admin'); ?></label>
                                    <input id="blockquote-name" name="blockquote-name" type="text" value=""/>
                                </div>
                            </div>
                            <!-- DROPCAP -->
                            <div id="typo-dropcap">
                                <h5><?php echo esc_attr_e('Dropcap', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="dropcap-type"><?php echo esc_attr_e('Dropcap Type', 'imic-framework-admin'); ?></label>
                                    <select id="dropcap-type" name="dropcap-type">
                                        <option value=""><?php echo esc_attr_e('Style 1', 'imic-framework-admin'); ?></option>
                                        <option value="secondary"><?php echo esc_attr_e('Style 2', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <!-- CODE -->
                            <div id="typo-code">
                                <h5><?php echo esc_attr_e('Code', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="code-type"><?php echo esc_attr_e('Code Type', 'imic-framework-admin'); ?></label>
                                    <select id="code-type" name="code-type">
                                        <option value=""><?php echo esc_attr_e('Standard', 'imic-framework-admin'); ?></option>
                                        <option value="inline"><?php echo esc_attr_e('Inline', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                            </div>                            
                            <!-- Container -->
                            <div id="typo-container">
                                <h5><?php echo esc_attr_e('Container', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="container-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                    <input id="container-xclass" name="container-xclass" type="text" value=""/>
                                </div>
                            </div>                            
                            <!-- LABEL TAGS -->
                            <div id="typo-label">
                                <h5><?php echo esc_attr_e('Label', 'imic-framework-admin'); ?></h5>
                                <div class="option">
                                    <label for="label-type"><?php echo esc_attr_e('Select Label Tag', 'imic-framework-admin'); ?></label>
                                    <select id="label-type" name="label-type">
                                        <option value="label-default"><?php echo esc_attr_e('Default', 'imic-framework-admin'); ?></option>
                                        <option value="label-primary"><?php echo esc_attr_e('Primary', 'imic-framework-admin'); ?></option>
                                        <option value="label-success"><?php echo esc_attr_e('Success', 'imic-framework-admin'); ?></option>
                                        <option value="label-info"><?php echo esc_attr_e('Info', 'imic-framework-admin'); ?></option>
                                        <option value="label-warning"><?php echo esc_attr_e('Warning', 'imic-framework-admin'); ?></option>
                                        <option value="label-danger"><?php echo esc_attr_e('Danger', 'imic-framework-admin'); ?></option>
                                        <option value="label-dark"><?php echo esc_attr_e('Dark', 'imic-framework-admin'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	COLUMNS
                        //////////////////////////////-->
                        <div id="shortcode-columns" class="shortcode-option">
                            <h5><?php echo esc_attr_e('Columns', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="column-options"><?php echo esc_attr_e('Layout', 'imic-framework-admin'); ?></label>
                                <select id="column-options" name="column-options">
                                    <option value="0"></option>
                                    <option value="one_full"><?php echo esc_attr_e('1', 'imic-framework-admin'); ?></option>
                                    <option value="two_halves"><?php echo esc_attr_e('1/2 + 1/2', 'imic-framework-admin'); ?></option>
                                    <option value="one_halves_two_quarters"><?php echo esc_attr_e('1/2 + 1/4 + 1/4', 'imic-framework-admin'); ?></option>
                                    <option value="three_thirds"><?php echo esc_attr_e('1/3 + 1/3 + 1/3', 'imic-framework-admin'); ?></option>
                                    <option value="three_two_thirds"><?php echo esc_attr_e('1/3 + 2/3', 'imic-framework-admin'); ?></option>
                                    <option value="two_thirds_one_thirds"><?php echo esc_attr_e('2/3 + 1/3', 'imic-framework-admin'); ?></option>
                                    <option value="two_quarters_one_halves"><?php echo esc_attr_e('1/4 + 1/4 + 1/2', 'imic-framework-admin'); ?></option>
                                    <option value="one_quarters_one_halves_one_quarters"><?php echo esc_attr_e('1/4 + 1/2 + 1/4', 'imic-framework-admin'); ?></option>
                                    <option value="four_quarters"><?php echo esc_attr_e('1/4 + 1/4 + 1/4 + 1/4', 'imic-framework-admin'); ?></option>
                                    <option value="six_one_sixths"><?php echo esc_attr_e('1/6 + 1/6 + 1/6 + 1/6 + 1/6 + 1/6', 'imic-framework-admin'); ?></option>
                                    <option value=""><?php echo esc_attr_e('Custom', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="column-xclass"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                <input id="column-xclass" name="column-xclass" type="text" value=""/>
                            </div>
                            <div class="option">
                                <label for="column-animation"><?php echo esc_attr_e('Animation', 'imic-framework-admin'); ?></label>
                                <select id="column-animation" name="column-animation">
                                    <option value=""></option>
                                    <option value="bounceInRight"><?php echo esc_attr_e('From Right', 'imic-framework-admin'); ?></option>
                                    <option value="bounceInLeft"><?php echo esc_attr_e('From Left', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	PROGRESS BAR
                        //////////////////////////////-->
                        <div id="shortcode-progressbar" class="shortcode-option">
                            <h5><?php _e('Progress Bar', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="progressbar-percentage"><?php echo esc_attr_e('Percentage', 'imic-framework-admin'); ?></label>
                                <input id="progressbar-percentage" name="progressbar-percentage" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Enter the percentage of the progress bar.', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="progressbar-text"><?php echo esc_attr_e('Progress Text', 'imic-framework-admin'); ?></label>
                                <input id="progressbar-text" name="progressbar-text" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Enter the text that you\'d like shown above the bar, i.e. "COMPLETED".', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="progressbar-value"><?php echo esc_attr_e('Progress Value', 'imic-framework-admin'); ?></label>
                                <input id="progressbar-value" name="progressbar-value" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Enter value that you\'d like shown at the end of the bar on completion, i.e. "90".', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="progressbar-type"><?php echo esc_attr_e('Progress Bar Type', 'imic-framework-admin'); ?></label>
                                <select id="progressbar-type" name="progressbar-type">
                                    <option value=""><?php echo esc_attr_e('Standard', 'imic-framework-admin'); ?></option>
                                    <option value="progress-striped"><?php echo esc_attr_e('Striped', 'imic-framework-admin'); ?></option>
                                    <option value="colored"><?php echo esc_attr_e('Colored', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="progressbar-colour"><?php echo esc_attr_e('Progress Bar Colour Type', 'imic-framework-admin'); ?></label>
                                <select id="progressbar-colour" name="progressbar-colour">
                                    <option value="progress-bar-primary"><?php echo esc_attr_e('Primary', 'imic-framework-admin'); ?></option>
                                    <option value="progress-bar-success"><?php echo esc_attr_e('Success', 'imic-framework-admin'); ?></option>
                                    <option value="progress-bar-info"><?php echo esc_attr_e('Info', 'imic-framework-admin'); ?></option>
                                    <option value="progress-bar-warning"><?php echo esc_attr_e('Warning', 'imic-framework-admin'); ?></option>
                                    <option value="progress-bar-danger"><?php echo esc_attr_e('Danger', 'imic-framework-admin'); ?></option>
                                </select>
                                <p class="info"><?php echo esc_attr_e('Select progress bar color for progress bar type striped and colored.', 'imic-framework-admin'); ?></p>
                            </div>
                        </div>
                        <!--//////////////////////////////
                                                ////	MODAL BOX
                                                //////////////////////////////-->
                        <div id="shortcode-modal" class="shortcode-option">
                            <h5><?php echo esc_attr_e('Modal Box', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="modal-id"><?php echo esc_attr_e('Modal Box ID', 'imic-framework-admin'); ?></label>
                                <input id="modal-id" name="modal-id" type="text" value=''/>
                            </div>
                            <div class="option">
                                <label for="modal-title"><?php echo esc_attr_e('Modal Box Title', 'imic-framework-admin'); ?></label>
                                <input id="modal-title" name="modal-title" type="text" value=''/>
                            </div>
                            <div class="option">
                                <label for="modal-text"><?php echo esc_attr_e('Modal Box Body Text', 'imic-framework-admin'); ?></label>
                                <input id="modal-text" name="modal-text" type="text" value=''/>
                            </div>
                            <div class="option">
                                <label for="modal-button"><?php echo esc_attr_e('Modal Box Button Text', 'imic-framework-admin'); ?></label>
                                <input id="modal-button" name="modal-button" type="text" value=''/>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	TOOLTIP
                        //////////////////////////////-->
                        <div id="shortcode-tooltip" class="shortcode-option">
                            <h5><?php echo esc_attr_e('Tooltip', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="tooltip-text"><?php echo esc_attr_e('Text', 'imic-framework-admin'); ?></label>
                                <input id="tooltip-text" name="tooltip-text" type="text" value=''/>
                                <p class="info"><?php echo esc_attr_e('Enter the text for the tooltip.', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="tooltip-link"><?php echo esc_attr_e('Link', 'imic-framework-admin'); ?></label>
                                <input id="tooltip-link" name="tooltip-link" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Enter the link that the tooltip text links to.', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="tooltip-direction"><?php echo esc_attr_e('Direction', 'imic-framework-admin'); ?></label>
                                <select id="tooltip-direction" name="tooltip-direction">
                                    <option value="top"><?php echo esc_attr_e('Top', 'imic-framework-admin'); ?></option>
                                    <option value="bottom"><?php echo esc_attr_e('Bottom', 'imic-framework-admin'); ?></option>
                                    <option value="left"><?php echo esc_attr_e('Left', 'imic-framework-admin'); ?></option>
                                    <option value="right"><?php echo esc_attr_e('Right', 'imic-framework-admin'); ?></option>
                                </select>
                                <p class="info"><?php echo esc_attr_e('Choose the direction in which the tooltip appears.', 'imic-framework-admin'); ?></p>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	COUNTERS
                        //////////////////////////////-->
                        <div id="shortcode-counters" class="shortcode-option">
                            <h5><?php echo esc_attr_e('Counters', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="count-to"><?php echo esc_attr_e('To Value', 'imic-framework-admin'); ?></label>
                                <input id="count-to" name="count-to" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Enter the number from which the counter counts up to.', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="count-subject"><?php echo esc_attr_e('Subject Text', 'imic-framework-admin'); ?></label>
                                <input id="count-subject" name="count-subject" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Enter the text which you would like to show below the counter.', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="count-speed"><?php echo esc_attr_e('Speed', 'imic-framework-admin'); ?></label>
                                <input id="count-speed" name="count-speed" type="text" value=""/>
                                <p class="info"><?php echo esc_attr_e('Enter the time you want the counter to take to complete, this is in milliseconds and optional. The default is 2000.', 'imic-framework-admin'); ?></p>
                            </div>
                            <div class="option">
                                <label for="count-image"><?php echo esc_attr_e('Icon image', 'imic-framework-admin'); ?></label>
                                <input id="count-image" name="count-image" type="text" value="" style="visibility: hidden;"/>
                                <?php echo '<ul class="font-icon-grid">'.$icon_list.'</ul>'; ?>
                            </div>
                            <div class="option">
                                <label for="count-textstyle"><?php echo esc_attr_e('Text style', 'imic-framework-admin'); ?></label>
                                <select id="count-textstyle" name="count-textstyle">
                                    <option value="div"><?php echo esc_attr_e('Default', 'imic-framework-admin'); ?></option>
                                    <option value="h3"><?php echo esc_attr_e('H3', 'imic-framework-admin'); ?></option>
                                    <option value="h6"><?php echo esc_attr_e('H6', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                         <!--//////////////////////////////
                        ////	PRICING TABLE
                        //////////////////////////////-->
                        <div id="shortcode-pricing-table" class="shortcode-option">
                            <h5><?php echo esc_attr_e('Pricing Table', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="pricing-table-columns"><?php echo esc_attr_e('Number of columns', 'imic-framework-admin'); ?></label>
                                <select id="pricing-table-columns" name="pricing-table-columns">
                                    <option value="3"><?php echo esc_attr_e('3', 'imic-framework-admin'); ?></option>
                                    <option value="4"><?php echo esc_attr_e('4', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="pricing-table-active"><?php echo esc_attr_e('Active Column', 'imic-framework-admin'); ?></label>
                                <select id="pricing-table-active" name="pricing-table-active">
                                    <option value="1"><?php echo esc_attr_e('1', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('2', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('3', 'imic-framework-admin'); ?></option>
                                    <option value="4"><?php echo esc_attr_e('4', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="pricing-table-rows"><?php echo esc_attr_e('Number of rows', 'imic-framework-admin'); ?></label>
                                <select id="pricing-table-rows" name="pricing-table-rows">
                                    <option value="1"><?php echo esc_attr_e('1', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('2', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('3', 'imic-framework-admin'); ?></option>
                                    <option value="4"><?php echo esc_attr_e('4', 'imic-framework-admin'); ?></option>
                                    <option value="5"><?php echo esc_attr_e('5', 'imic-framework-admin'); ?></option>
                                    <option value="6"><?php echo esc_attr_e('6', 'imic-framework-admin'); ?></option>
                                    <option value="7"><?php echo esc_attr_e('7', 'imic-framework-admin'); ?></option>
                                    <option value="8"><?php echo esc_attr_e('8', 'imic-framework-admin'); ?></option>
                                    <option value="9"><?php echo esc_attr_e('9', 'imic-framework-admin'); ?></option>
                                    <option value="10"><?php echo esc_attr_e('10', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="pricing-currency"><?php echo esc_attr_e('Currency', 'imic-framework-admin'); ?></label>
                                <input id="pricing-currency" name="pricing-currency" type="text" value=""/>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	TABLE
                        //////////////////////////////-->
                        <div id="shortcode-tables" class="shortcode-option">
                            <h5><?php echo esc_attr_e('Table', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="table-type"><?php echo esc_attr_e('Table style', 'imic-framework-admin'); ?></label>
                                <select id="table-type" name="table-type">
                                    <option value="table-striped"><?php echo esc_attr_e('Striped table', 'imic-framework-admin'); ?></option>
                                    <option value="table-bordered"><?php echo esc_attr_e('Bordered table', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="table-head"><?php echo esc_attr_e('Table Head', 'imic-framework-admin'); ?></label>
                                <select id="table-head" name="table-head">
                                    <option value="yes"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                    <option value="no"><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                    <p class="info">Include a heading row in the table</p>
                                </select>
                            </div>
                            <div class="option">
                                <label for="table-columns"><?php echo esc_attr_e('Number of columns', 'imic-framework-admin'); ?></label>
                                <select id="table-columns" name="table-columns">
                                    <option value="1"><?php echo esc_attr_e('1', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('2', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('3', 'imic-framework-admin'); ?></option>
                                    <option value="4"><?php echo esc_attr_e('4', 'imic-framework-admin'); ?></option>
                                    <option value="5"><?php echo esc_attr_e('5', 'imic-framework-admin'); ?></option>
                                    <option value="6"><?php echo esc_attr_e('6', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="table-rows"><?php echo esc_attr_e('Number of rows', 'imic-framework-admin'); ?></label>
                                <select id="table-rows" name="table-rows">
                                    <option value="1"><?php echo esc_attr_e('1', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('2', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('3', 'imic-framework-admin'); ?></option>
                                    <option value="4"><?php echo esc_attr_e('4', 'imic-framework-admin'); ?></option>
                                    <option value="5"><?php echo esc_attr_e('5', 'imic-framework-admin'); ?></option>
                                    <option value="6"><?php echo esc_attr_e('6', 'imic-framework-admin'); ?></option>
                                    <option value="7"><?php echo esc_attr_e('7', 'imic-framework-admin'); ?></option>
                                    <option value="8"><?php echo esc_attr_e('8', 'imic-framework-admin'); ?></option>
                                    <option value="9"><?php echo esc_attr_e('9', 'imic-framework-admin'); ?></option>
                                    <option value="10"><?php echo esc_attr_e('10', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                        <!--//////////////////////////////
                        ////	LISTS
                        //////////////////////////////-->
                        <div id="shortcode-lists" class="shortcode-option">
                            <h5><?php echo esc_attr_e('Lists', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="list-type"><?php echo esc_attr_e('List style', 'imic-framework-admin'); ?></label>
                                <select id="list-type" name="list-type">
                                    <option value=""><?php echo esc_attr_e('Custom Unordered List', 'imic-framework-admin'); ?></option>
                                    <option value="unordered"><?php echo esc_attr_e('Unordered List', 'imic-framework-admin'); ?></option>
                                    <option value="ordered"><?php echo esc_attr_e('Ordered List', 'imic-framework-admin'); ?></option>
                                    <option value="icon"><?php echo esc_attr_e('Icon List', 'imic-framework-admin'); ?></option>
                                    <option value="inline"><?php echo esc_attr_e('Inline List', 'imic-framework-admin'); ?></option>
                                    <option value="desc"><?php echo esc_attr_e('Description List', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                            <div class="option">
                                <label for="list-icon"><?php echo esc_attr_e('List icon', 'imic-framework-admin'); ?></label>
                                <input id="list-icon" name="list-icon" type="text" value="" style="visibility: hidden;"/>
                                <?php echo '<ul class="font-icon-grid">'.$icon_list.'</ul>'; ?>
                            </div>
                            <div class="option">
                                <label for="list-items"><?php echo esc_attr_e('Number of list items', 'imic-framework-admin'); ?></label>
                                <select id="list-items" name="list-items">
                                    <option value="1"><?php echo esc_attr_e('1', 'imic-framework-admin'); ?></option>
                                    <option value="2"><?php echo esc_attr_e('2', 'imic-framework-admin'); ?></option>
                                    <option value="3"><?php echo esc_attr_e('3', 'imic-framework-admin'); ?></option>
                                    <option value="4"><?php echo esc_attr_e('4', 'imic-framework-admin'); ?></option>
                                    <option value="5"><?php echo esc_attr_e('5', 'imic-framework-admin'); ?></option>
                                    <option value="6"><?php echo esc_attr_e('6', 'imic-framework-admin'); ?></option>
                                    <option value="7"><?php echo esc_attr_e('7', 'imic-framework-admin'); ?></option>
                                    <option value="8"><?php echo esc_attr_e('8', 'imic-framework-admin'); ?></option>
                                    <option value="9"><?php echo esc_attr_e('9', 'imic-framework-admin'); ?></option>
                                    <option value="10"><?php echo esc_attr_e('10', 'imic-framework-admin'); ?></option>
                                    <p class="info">You can easily add more by duplicating the code after.</p>
                                </select>
                            </div>
                            <div class="option">
                                <label for="list-extra"><?php echo esc_attr_e('Add Extra Class', 'imic-framework-admin'); ?></label>
                                <input id="list-extra" name="list-extra" type="text" value="" />
                            </div>
                        </div>
                        <!--//////////////////////////////
                                                ////	Tabs
                                                //////////////////////////////-->
                        <div id="shortcode-tabs">
                            <h5><?php echo esc_attr_e('Tabs', 'imic-framework-admin'); ?></h5>                            
                            <div class="option">
                                <label for="tabs-id"><?php echo esc_attr_e('Tab ID', 'imic-framework-admin'); ?></label>
                                <input id="tabs-id" name="tabs-id" type="text" value=""/>
                            </div>
                            <div class="option">
                                <label for="tabs-size"><?php echo esc_attr_e('Number of Tabs', 'imic-framework-admin'); ?></label>								<input id="tabs-size" name="tabs-size" type="text" value=""/>
                            </div>
                        </div>
                        
                        <!--//////////////////////////////
                                                ////	Accordions
                                                //////////////////////////////-->
                        <div id="shortcode-accordion">
                            <h5><?php echo esc_attr_e('Accordions', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="accordion-id"><?php echo esc_attr_e('Accordion ID', 'imic-framework-admin'); ?></label>
                                <input id="accordion-id" name="accordion-id" type="text" value=""/>
                            </div>
                            <div class="option">
                                <label for="accordion-size"><?php echo esc_attr_e('Number of Accordions', 'imic-framework-admin'); ?></label>
                                <input id="accordion-size" name="accordion-size" type="text" value=""/>
                            </div>
                        </div>
                        <!--//////////////////////////////
                                                ////	Toggles
                                                //////////////////////////////-->
                        <div id="shortcode-toggle">
                            <h5><?php echo esc_attr_e('Toggles', 'imic-framework-admin'); ?></h5>
                            <div class="option">
                                <label for="toggle-id"><?php echo esc_attr_e('Toggle ID', 'imic-framework-admin'); ?></label>
                                <input id="toggle-id" name="toggle-id" type="text" value=""/>
                            </div>
                            <div class="option">
                                <label for="toggle-size"><?php echo esc_attr_e('Number of Toggles', 'imic-framework-admin'); ?></label>
                                <input id="toggle-size" name="toggle-size" type="text" value=""/>
                            </div>
                        </div>
                       <!--//////////////////////////////
                                                ////	Form
                                                //////////////////////////////-->
                        <div id="shortcode-form">
                            <h5><?php echo esc_attr_e('Form', 'imic-framework-admin'); ?></h5>
                        <div class="option">
                                    <label for="form-title"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
                                    <input id="form-title" name="form-title" type="text" value=""/>
                                </div>
                            <!--<div class="option">
                                <label for="toggle-size"><?php echo esc_attr_e('Enter Email with comma seperated', 'imic-framework-admin'); ?></label>
                                <input id="form_email" name="form_email" type="text" value=""/>
                            </div>-->
                        </div>
                        <!--//////////////////////////////
                                                //// Calendar	
                                                //////////////////////////////-->
                        <div id="shortcode-calendar">
                         <h5><?php echo esc_attr_e('Calendar', 'imic-framework-admin'); ?></h5>
                        <div class="option">
                        <label for="calendar_event_category"><?php echo esc_attr_e('Calendar Event Categories', 'imic-framework-admin'); ?></label>
                        <select id="calendar_event_category" name="calendar_event_category">
                        <option value=""><?php echo esc_attr_e('Select', 'imic-framework-admin'); ?></option>
                        <?php
						if(!empty($e_terms)) { 
                        foreach ($e_terms as $term) {
                           echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                        } }
                        ?>
                        </select>
                        </div>
                        <div class="option">
                                <label for="calendar-filter"><?php echo esc_attr_e('Calendar Filter', 'imic-framework-admin'); ?></label>
                                <select id="calendar-filter" name="calendar-filter">
                                    <option value=""><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                    <option value="1"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                       	<div class="option">
                                <label for="calendar-preview"><?php echo esc_attr_e('Events Preview', 'imic-framework-admin'); ?></label>
                                <select id="calendar-preview" name="calendar-preview">
                                    <option value=""><?php echo esc_attr_e('No', 'imic-framework-admin'); ?></option>
                                    <option value="1"><?php echo esc_attr_e('Yes', 'imic-framework-admin'); ?></option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <!-- CLOSE #shortcode_panel -->					
                </div>
                <div class="buttons clearfix">
                    <input type="submit" id="insert" name="insert" value="<?php echo esc_attr_e('Insert Shortcode', 'imic-framework-admin'); ?>" onClick="embedSelectedShortcode();" />
                </div>
                <!-- CLOSE #shortcode_wrap -->
            </div>
            <!-- CLOSE imicframework_shortcode_form -->
        </form>
        <!-- CLOSE body -->
    </body>
    <!-- CLOSE html -->	
</html>