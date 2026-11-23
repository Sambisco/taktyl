<!doctype html>
<html>
<head>
    <title>Mixed Controls Demo | jPList - jQuery Data Grid Controls</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../include/script.php');
include('../include/database.php');
include('../include/css.php');
include('../include/sidebar.php');
include('../include/topbar.php');
$timezone="UTC"; 
date_default_timezone_set($timezone);
?>
    <!-- font libs -->
     <!-- jPList start -->
    <script>
        $('document').ready(function(){

            $('#demo').jplist({
                itemsBox: '.list'
                ,itemPath: '.list-item'
                ,panelPath: '.jplist-panel'
                //,debug: true
            });
        });
    </script>

</head>
<body>

<!-- top bar -->
<div id="black-top-bar" class="box">
    <div class="center">
        <div class="box">

            <!-- left menu -->
            <ul id="black-top-bar-left-menu" class="hmenu left iphone-hidden">
                <li class="glow">
                    <a title="" href="https://github.com/no81no/jplist/issues?state=open">
                        <i class="fa fa-asterisk"></i> Request a feature / <i class="fa fa-bug"></i> Report a bug
                    </a>
                </li>
            </ul>

            <!-- social menu -->
            <ul id="social-menu" class="hmenu right">
                <li class="glow"><a title="" href="https://www.facebook.com/jplist"><i class="fa fa-facebook"></i>&nbsp;</a></li>
                <li class="glow"><a rel="publisher" title="" href="https://plus.google.com/+Jplistjs"><i class="fa fa-google-plus"></i></a></li>
                <li class="glow"><a title="" href="https://twitter.com/jquery_jplist"><i class="fa fa-twitter"></i></a></li>
                <li class="glow"><a title="" href="https://github.com/no81no/jplist"><i class="fa fa-github"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<!-- header -->
<header id="header" class="box">
    <div id="header-box" class="box">
        <div class="center">
            <div class="box">

                <!-- logo -->
                <div class="align-center text-shadow" id="logo">
                    <p>
                        <img title="jPList - jQuery Data Grid Controls" alt="jPList - jQuery Data Grid Controls" src="http://jplist.com/content/img/common/rocket.png" />
                        <a title="" href="http://jplist.com">jPList - jQuery Data Grid Controls</a>
                    </p>
                    <h1 class="h1-30-normal">Mixed Controls Demo</h1>
                </div>

            </div>
        </div>
    </div>
</header>

<!-- main content -->
<div class="box">
    <div class="center">
        <!--<><><><><><><><><><><><><><><><><><><><><><><><><><> DEMO START <><><><><><><><><><><><><><><><><><><><><><><><><><>-->

        <!-- demo -->
        <div id="demo" class="box jplist" style="margin: 20px 0 50px 0">

            <!-- ios button: show/hide panel -->
            <div class="jplist-ios-button">
                <i class="fa fa-sort"></i>
                jPList Actions
            </div>
           
            <!-- panel -->
            <div class="jplist-panel box panel-top">

                <!-- back button button -->
                <button
                        type="button"
                        data-control-type="back-button"
                        data-control-name="back-button"
                        data-control-action="back-button">
                    <i class="fa fa-arrow-left"></i> Go Back
                </button>

                <!-- reset button -->
                <button
                        type="button"
                        class="jplist-reset-btn"
                        data-control-type="reset"
                        data-control-name="reset"
                        data-control-action="reset">
                    Reset &nbsp;<i class="fa fa-share"></i>
                </button>

                <!-- items per page dropdown -->
                <div class="dropdown">
  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    <span>Dropdown button</span>
  </button>
  <div class="dropdown-menu " data-control-type="items-per-page-drop-down" data-toggle="dropdown"
                        data-control-name="paging"
                        data-control-action="paging">
                        <li class="dropdown-item"><span data-number="3"> 3 per page </span></li>
                        <li class="dropdown-item"><span data-number="5"> 5 per page </span></li>
                        <li class="dropdown-item"><span data-number="10" data-default="false"> 10 per page </span></li>
                        <li class="dropdown-item"><span data-number="all"> View All </span></li>
  </div>
</div>
                <div
                        class="jplist-drop-down"
                        data-control-type="items-per-page-drop-down"
                        data-control-name="paging"
                        data-control-action="paging">

                    <ul>
                        <li><span data-number="3"> 3 per page </span></li>
                        <li><span data-number="5"> 5 per page </span></li>
                        <li><span data-number="10" data-default="true"> 10 per page </span></li>
                        <li><span data-number="all"> View All </span></li>
                    </ul>
                </div>

                <!-- sort dropdown -->
                <div
                        class="jplist-drop-down"
                        data-control-type="sort-drop-down"
                        data-control-name="sort"
                        data-control-action="sort"
                        data-datetime-format="{month}/{day}/{year}"> <!-- {year}, {month}, {day}, {hour}, {min}, {sec} -->

                    <ul>
                        <li><span data-path="default">Sort by</span></li>
                        <li><span data-path=".title" data-order="asc" data-type="text">Title A-Z</span></li>
                        <li><span data-path=".title" data-order="desc" data-type="text">Title Z-A</span></li>
                        <li><span data-path=".desc" data-order="asc" data-type="text">Description A-Z</span></li>
                        <li><span data-path=".desc" data-order="desc" data-type="text">Description Z-A</span></li>
                        <li><span data-path=".like" data-order="asc" data-type="number" data-default="true">Likes asc</span></li>
                        <li><span data-path=".like" data-order="desc" data-type="number">Likes desc</span></li>
                        <li><span data-path=".date" data-order="asc" data-type="datetime">Date asc</span></li>
                        <li><span data-path=".date" data-order="desc" data-type="datetime">Date desc</span></li>
                    </ul>
                </div>

                <!-- filter by title -->
                <div class="text-filter-box">

                    <i class="fa fa-search  jplist-icon"></i>

                    <!--[if lt IE 10]>
                    <div class="jplist-label">Filter by Title:</div>
                    <![endif]-->

                    <input
                            data-path=".title"
                            type="text"
                            value=""
                            placeholder="Filter by Title"
                            data-control-type="textbox"
                            data-control-name="title-filter"
                            data-control-action="filter"
                    />
                </div>

                <!-- filter by description -->
                <div class="text-filter-box">

                    <i class="fa fa-search  jplist-icon"></i>

                    <!--[if lt IE 10]>
                    <div class="jplist-label">Filter by Description:</div>
                    <![endif]-->

                    <input
                            data-path=".desc"
                            type="text"
                            value=""
                            placeholder="Filter by Description"
                            data-control-type="textbox"
                            data-control-name="desc-filter"
                            data-control-action="filter"
                    />
                </div>

                <div class="jplist-group">
                    <ul>
                        <li>
						<span
                                data-control-type="button-filter"
                                data-control-action="filter"
                                data-control-name="architecture-btn"
                                data-path=".architecture"
                                data-selected="true">
								<i class="fa fa-caret-right"></i>
								Architecture
						</span>

                        <li>
						<span
                                data-control-type="button-filter"
                                data-control-action="filter"
                                data-control-name="christmas-btn"
                                data-path=".christmas">
								<i class="fa fa-caret-right"></i>
								Christmas
						</span>

                        <li>
						<span
                                data-control-type="button-filter"
                                data-control-action="filter"
                                data-control-name="nature-btn"
                                data-path=".nature">
								<i class="fa fa-caret-right"></i>
								Nature
						</span>

                        <li>
						<span
                                data-control-type="button-filter"
                                data-control-action="filter"
                                data-control-name="lifestyle-btn"
                                data-path=".lifestyle">
								<i class="fa fa-caret-right"></i>
								Lifestyle
						</span>

                    </ul>
                </div>

                <!-- pagination results -->
                <div
                        class="jplist-label"
                        data-type="Page {current} sur {pages}"
                        data-control-type="pagination-info"
                        data-control-name="paging"
                        data-control-action="paging">
                </div>

                <!-- pagination control -->
                <div
                        class="jplist-pagination"
                        data-control-type="pagination"
                        data-control-name="paging"
                        data-control-action="paging">
                </div>

            </div>

            <!-- data -->
            <div class="table-responsive p-3 bg-gradient-login">
            <div class="row mb-3 list box text-shadow">

            <div class="col-xl-2 col-md-2 mb-3  list-item box" id="sous_content1_<?php echo $count; ?>">
              <div class="card h-70 ">
                <div class="card-body ">
                <center>
                        <p class="date">03/18/2012</p>
                        <p class="title">Architecture</p>
                        <p class="desc">Architecture is both the process and product of planning, designing and construction. Architectural works, in the material form of buildings, are often perceived as cultural symbols and as works of art. Historical civilizations are often identified with their surviving architectural achievements.</p>
                        <p class="like">25 Likes</p>
                        <p class="theme">
                            <span class="architecture">Architecture</span>
                        </p>
                  <label class="toggle">
    <input type="checkbox" id="reserver" data-id="<?php echo $row['id_chambre']; ?>">
    <span class="slider"></span>
    <span class="labels" data-on="Annuler" data-off="Reserver" ></span>
  </label>

                  </center>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-2 mb-3  list-item box" id="sous_content1_<?php echo $count; ?>">
              <div class="card h-70 ">
                <div class="card-body ">
                <center>
                        <p class="date">03/18/2012</p>
                        <p class="title">mOUlin</p>
                        <p class="desc">Architecture is both the process and product of planning, designing and construction. Architectural works, in the material form of buildings, are often perceived as cultural symbols and as works of art. Historical civilizations are often identified with their surviving architectural achievements.</p>
                        <p class="like">25 Likes</p>
                        <p class="theme">
                            <span class="architecture">mOUlin</span>
                        </p>
                  <label class="toggle">
    <input type="checkbox" id="reserver" data-id="<?php echo $row['id_chambre']; ?>">
    <span class="slider"></span>
    <span class="labels" data-on="Annuler" data-off="Reserver" ></span>
  </label>

                  </center>
                </div>
              </div>
            </div>
           
            

                <!-- item 2 -->
                
            </div>


            <div class="box jplist-no-results text-shadow align-center">
                <p>No results found</p>
            </div>

            <!-- ios button: show/hide panel -->
            <div class="jplist-ios-button">
                <i class="fa fa-sort"></i>
                jPList Actions
            </div>

            <!-- panel -->
            <div class="jplist-panel box panel-bottom">

                <!-- items per page dropdown -->
                <div
                        class="jplist-drop-down"
                        data-control-type="items-per-page-drop-down"
                        data-control-name="paging"
                        data-control-action="paging"
                        data-control-animate-to-top="true">

                    <ul>
                        <li><span data-number="3"> 3 per page </span></li>
                        <li><span data-number="5"> 5 per page </span></li>
                        <li><span data-number="10" data-default="true"> 10 per page </span></li>
                        <li><span data-number="all"> View All </span></li>
                    </ul>
                </div>

                <!-- sort dropdown -->
                <div
                        class="jplist-drop-down"
                        data-control-type="sort-drop-down"
                        data-control-name="sort"
                        data-control-action="sort"
                        data-control-animate-to-top="true"
                        data-datetime-format="{month}/{day}/{year}"> <!-- {year}, {month}, {day}, {hour}, {min}, {sec} -->

                    <ul>
                        <li><span data-path="default">Sort by</span></li>
                        <li><span data-path=".title" data-order="asc" data-type="text">Title A-Z</span></li>
                        <li><span data-path=".title" data-order="desc" data-type="text">Title Z-A</span></li>
                        <li><span data-path=".desc" data-order="asc" data-type="text">Description A-Z</span></li>
                        <li><span data-path=".desc" data-order="desc" data-type="text">Description Z-A</span></li>
                        <li><span data-path=".like" data-order="asc" data-type="number" data-default="true">Likes asc</span></li>
                        <li><span data-path=".like" data-order="desc" data-type="number">Likes desc</span></li>
                        <li><span data-path=".date" data-order="asc" data-type="datetime">Date asc</span></li>
                        <li><span data-path=".date" data-order="desc" data-type="datetime">Date desc</span></li>
                    </ul>
                </div>

                <!-- pagination results -->
                <div
                        class="jplist-label"
                        data-type="{start} - {end} of {all}"
                        data-control-type="pagination-info"
                        data-control-name="paging"
                        data-control-action="paging">
                </div>

                <!-- pagination -->
                <div
                        class="jplist-pagination"
                        data-control-animate-to-top="true"
                        data-control-type="pagination"
                        data-control-name="paging"
                        data-control-action="paging">
                </div>

            </div>

        </div>
        <!-- end of demo -->
        <!--<><><><><><><><><><><><><><><><><><><><><><><><><><> DEMO END <><><><><><><><><><><><><><><><><><><><><><><><><><>-->
    </div>
</div>

<!-- footer -->
<footer class="box" id="footer">
    <div class="center">
        <div class="box">
            <p id="footer-content" class="align-center glow">
                <a href="http://jplist.com" title="">Copyright &copy; <script>document.write(new Date().getFullYear())</script> <b>jPList Software</b></a>
            </p>
        </div>
    </div>
</footer>
</body>
</html>