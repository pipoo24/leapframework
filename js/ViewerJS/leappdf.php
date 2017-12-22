<!DOCTYPE html>

<!--
  Copyright (C) 2012-2014 KO GmbH <copyright@kogmbh.com>

  @licstart
  This file is part of WebODF.

  WebODF is free software: you can redistribute it and/or modify it
  under the terms of the GNU Affero General Public License (GNU AGPL)
  as published by the Free Software Foundation, either version 3 of
  the License, or (at your option) any later version.

  WebODF is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU Affero General Public License for more details.

  You should have received a copy of the GNU Affero General Public License
  along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
  @licend

  @source: http://www.webodf.org/
  @source: https://github.com/kogmbh/WebODF/
-->

<!--
  This file is a derivative from a part of Mozilla's PDF.js project. The
  original license header follows.
-->

<!--
Copyright 2012 Mozilla Foundation

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->

<html dir="ltr" lang="en-US">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>ViewerJS</title>
        <!-- If you want to use custom CSS (@font-face rules, for example) you should uncomment
             the following reference and use a local.css file for that. See the example.local.css
             file for a sample.
        <link rel="stylesheet" type="text/css" href="local.css" media="screen"/>
        -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" type="text/css" href="viewer.css" media="screen"/>
	    <link rel="icon"
	          type="image/png"
	          href="../../kcfinder/favicon.ico" />
        <script src="viewer.js" type="text/javascript" charset="utf-8"></script>
        <script src="PluginLoader.js" type="text/javascript" charset="utf-8"></script>
                <script>
/*document.title='<?=$_GET['nn'];?>';
alert(document.title);
document.getElementById("documentName").innerHTML=document.title;*/
    var namefil ='<?=$_GET['nn'];?>';
        </script>
        <script>
            loadDocument(window.location.hash);
        </script>
<script language=JavaScript>
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
//alert(message);
console.log(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
//alert(message);
console.log(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("console.log(message);return false")

// --> 
/*
 * tambahan roy supaya benar
 */


</script>
    </head>

    <body>
        <div id = "viewer">
            <div id = "titlebar">
                <div id = "documentName"></div>
                <div id = "toolbarRight">
                    <button id = "presentation" class = "toolbarButton presentation" title = "Presentation"></button>
                    <button id = "fullscreen" class = "toolbarButton fullscreen" title = "Fullscreen"></button>
                    <button <? if($_GET['dd']=="reg"){?>style="display:none;"<?}?> id = "download" class = "toolbarButton download" title = "Download"></button>
                </div>
           </div>
            <div id = "toolbarContainer">
                <div id = "toolbar">
                    <div id = "toolbarLeft">
                        <div id = "navButtons" class = "splitToolbarButton">
                            <button id = "previous" class = "toolbarButton pageUp" title = "Previous Page"></button>
                            <div class="splitToolbarButtonSeparator"></div>
                            <button id = "next" class = "toolbarButton pageDown" title = "Next Page"></button>
                        </div>
                        <label id = "pageNumberLabel" class = "toolbarLabel" for = "pageNumber">Page:</label>
                        <input type = "number" id = "pageNumber" class = "toolbarField pageNumber"/>
                        <span id = "numPages" class = "toolbarLabel"></span>
                    </div>
                    <div id = "toolbarMiddleContainer" class = "outerCenter">
                        <div id = "toolbarMiddle" class = "innerCenter">
                            <div id = 'zoomButtons' class = "splitToolbarButton">
                                <button id = "zoomOut" class = "toolbarButton zoomOut" title = "Zoom Out"></button>
                                <div class="splitToolbarButtonSeparator"></div>
                                <button id = "zoomIn" class = "toolbarButton zoomIn" title = "Zoom In"></button>
                            </div>
                            <span id="scaleSelectContainer" class="dropdownToolbarButton">
                                <select id="scaleSelect" title="Zoom" oncontextmenu="return false;">
                                    <option id="pageAutoOption" value="auto" selected>Automatic</option>
                                    <option id="pageActualOption" value="page-actual">Actual Size</option>
                                    <option id="pageWidthOption" value="page-width">Full Width</option>
                                    <option id="customScaleOption" value="custom"> </option>
                                    <option value="0.5">50%</option>
                                    <option value="0.75">75%</option>
                                    <option value="1">100%</option>
                                    <option value="1.25">125%</option>
                                    <option value="1.5">150%</option>
                                    <option value="2">200%</option>
                                </select>
                            </span>
                            <div id = "sliderContainer">
                                <div id = "slider"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id = "canvasContainer">
                <div id = "canvas" oncontextmenu="return false;"></div>
            </div>
            <div id = "overlayNavigator">
                <div id = "previousPage"></div>
                <div id = "nextPage"></div>
            </div>
            <div id = "overlayCloseButton">
            &#10006;
            </div>
            <div id = "dialogOverlay"></div>
            <div id = "blanked"></div>
        </div>

    </body>
    
</html>
