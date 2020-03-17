<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Is Pwa Studio ?</title>
    <link rel="icon" type="image/png" href="./img/icon-logo.png">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="./css/bootstrap/bootstrap.min.css.map"/>
    <link rel="stylesheet" type="text/css" href="./css/index.css"/>
</head>
<body>

<div id="root">

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xl-12 col-xs-12">
                <div class="wrap">
                    <div class="logo">
                        <a href="https://simicart.com" target="_blank"><img class="img-responsive"
                                                                            src="./img/icon-logo.png"
                                                                            alt="simicart-logo"></a>
                    </div>
                    <div class="title">
                        IS PWA STUDIO ?
                    </div>
                </div>
                <div class="myform">
                    <form id="form-check" method="post"
                    ">
                    <fieldset>
                        <label for="urlInput">Full Website URL:</label>
                        <input id="urlInput" name="url" type="url"
                               placeholder="https://" autocomplete="off" required/>
                    </fieldset>
                    <br/>
                    <button type="submit" class="btn btn-default btn-check">Check Now</button>
                    <!-- Loading -->
                    <div class="loading">
                        <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="64px" height="64px"
                             viewBox="0 0 128 128" xml:space="preserve"><link xmlns="" type="text/css"
                                                                              id="dark-mode"
                                                                              rel="stylesheet" href=""/>
                            <style xmlns="" type="text/css" id="dark-mode-custom-style"/>
                            <g transform="rotate(45 64 64)">
                                <circle cx="16" cy="64" r="16" fill="#000"/>
                                <circle cx="16" cy="64" r="14.344" fill="#000" transform="rotate(45 64 64)"/>
                                <circle cx="16" cy="64" r="12.531" fill="#000" transform="rotate(90 64 64)"/>
                                <circle cx="16" cy="64" r="10.75" fill="#000" transform="rotate(135 64 64)"/>
                                <circle cx="16" cy="64" r="10.063" fill="#000" transform="rotate(180 64 64)"/>
                                <circle cx="16" cy="64" r="8.063" fill="#000" transform="rotate(225 64 64)"/>
                                <circle cx="16" cy="64" r="6.438" fill="#000" transform="rotate(270 64 64)"/>
                                <circle cx="16" cy="64" r="5.375" fill="#000" transform="rotate(315 64 64)"/>
                                <animateTransform attributeName="transform" type="rotate"
                                                  values="0 64 64;315 64 64;270 64 64;225 64 64;180 64 64;135 64 64;90 64 64;45 64 64"
                                                  calcMode="discrete" dur="720ms" repeatCount="indefinite"/>
                            </g></svg>
                    </div>
                    </form>
                </div>

                <div class="copyright">
                    © 2020 SimiCart. All Rights Reserved.
                </div>
                <!-- Modal Success -->
                <div class="modal fade" id="trueModal" role="dialog">
                    <div class="modal-dialog" style="margin: auto">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Result Analysis: <span class="true">TRUE</span></h4>
                            </div>
                            <div class="modal-body">
                                <img class="img-responsive" src="./img/true.png" alt="true-img">
                                <p><span class="website-true"></span> <span class="space">&nbsp</span> is PWA STUDIO.
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Fail -->
                <div class="modal fade" id="falseModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Result Analysis: <span class="false">FALSE</span></h4>
                            </div>
                            <div class="modal-body">
                                <img class="img-responsive" src="./img/false.png" alt="false-img">
                                <p><span class="website-false"></span> &nbsp is NOT PWA STUDIO.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script defer type="text/javascript" src="./js/jquery.min.js"></script>
<script defer type="text/javascript" src="./js/bootstrap.min.js"></script>
<script defer type="text/javascript" src="./js/index.js"></script>
</body>
</html>