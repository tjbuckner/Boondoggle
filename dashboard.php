<?php
    session_start();
    if (!(isset($_SESSION['login']))) {
        header("Location: loginForm.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Boondoggle Dashboard</title>
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/moment.js"></script>
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.0/fullcalendar.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="boondoggle.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.0/fullcalendar.min.js"></script>
    <script src="js/fullcalendar-2.2.0/gcal.js"></script>
    <script src="http://cdn.jsdelivr.net/qtip2/2.2.1/jquery.qtip.min.js"></script>
    <link rel="stylesheet" href="http://cdn.jsdelivr.net/qtip2/2.2.1/jquery.qtip.min.css">
    <link rel="stylesheet" href="js/jquery-timepicker/jquery.timepicker.css">
    <script type="text/javascript" src="js/jquery-timepicker/jquery.timepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-colorselector-master/lib/bootstrap-colorselector-0.2.0/js/bootstrap-colorselector.js"></script>
    <link rel="stylesheet" href="js/bootstrap-colorselector-master/lib/bootstrap-colorselector-0.2.0/css/bootstrap-colorselector.css">
    <script>
        $(document).ready(function () {

            var $autoresize = true;
            var $deleteClicked;
            var $submitClicked;

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                editable: false,
                height: 800,
                events: 'loadEvents.php',
                eventRender: function (event, element) {
                    element.qtip({
                        content: {
                            title:  function() {
                                        if (event.class_num !== "")  {
                                            return event.class_num + ' - ' + event.class_name + '<br />' +
                                            event.instructor_name;
                                        }
                                        else {
                                            return "No Class Defined";
                                        }
                                    },
                            text:   function() {
                                        if (event.title !== "")  {
                                            return event.title + '<br />' +
                                            event.description;
                                        }
                                        else {
                                            return "No Title" + '<br />' + event.description;
                                        }
                                    }
                        },
                        show: 'mouseover',
                        position: {
                            my: 'bottom center',
                            at: 'top center'
                        },
                        defaultAllDayEventDuration: '00:30:00'
                    });
                },
                eventLimit: true,
                eventLimitClick: "popover",
                eventLimitText: "more",
                dayClick: function (date, jsEvent, view) {
                    $("#date-title").html(date.format("dddd, MMMM Do"));
                    $("#due_date").val(date.format("YYYY-MM-DD"));
                    $("#year").html(date.format("YYYY"));
                    $("#class-select").val(0);
                    $(".delete-btn").hide();
                    $("#modal-form").attr("action", "addHomework.php");
                    $(".submit").html("Add Homework");
                    $("#title").val("");
                    $("#description").val("");
                    $("#addHomeworkModal").modal();
                    $("#timepicker").timepicker('setTime', date.format("h:mma"));

                },
                eventColor: '#336282',
                eventClick: function (calEvent, jsEvent, view) {
                    $("#date-title").html(calEvent.start.format("dddd, MMMM Do"));
                    $("#event_id").val(calEvent.id);
                    $("#due_date").val(calEvent.start.format("YYYY-MM-DD"));
                    $("#title").val(calEvent.title);
                    $("#class-select").val(calEvent.class_id);
                    $("#year").html(calEvent.start.format("YYYY"));
                    $("#description").val(calEvent.description);
                    $(".delete-btn").show();
                    $("#modal-form").attr("action", "modifyHomework.php");
                    $(".submit").html("Save Changes");
                    $("#addHomeworkModal").modal();
                    $("#timepicker").timepicker('setTime', calEvent.start.format("h:mma"));
                }
            });

            $('.selector').qtip({
                style: {
                    classes: 'qtip'
                }
            });

            $("input[type='text'], textarea").attr('spellcheck',false);

            $("#new-colorselector").colorselector();

            resizeCalendar();

            $(window).resize(function () {
                resizeCalendar();

            });

            function resizeCalendar() {
                var windowWidth = $(window).width();
                if (windowWidth < 600) {

                    $("#calendar").fullCalendar('option', 'height', 600);
                    $(".btn-changeview").css({"font-size":"9px"});
                    $('#calendar').fullCalendar('changeView', 'agendaDay');
                    $("#timepicker").css({"margin-left":"0px"});
                    $(".modal-labels").css({"margin-top":"5px","margin-bottom":"11px"});
                    $("#timepicker").css({"margin-bottom":"-4px"});
                    $("#title").css({"margin-bottom":"-4px"});
                    $(".manage-classes").hide();
                    $(".welcome-msg").hide();

                    if (windowWidth < 350){
                        $(".fc-center > h2").css("fontSize", "16px");
                        $(".fc-center > h2").css("marginTop", "3px");
                    }
                    else {
                        $(".fc-center > h2").css("fontSize", "20px");
                        $(".fc-center > h2").css("marginTop", "0px");
                    }
                }
                else if (windowWidth < 768) {

                    $('#calendar').fullCalendar('changeView', 'agendaWeek');
                    $("h2").css("fontSize", "20px");
                    $("#calendar").fullCalendar('option', 'height', 600);
                    $("#cal-bootstrap").addClass("col-lg-12");
                    $("#cal-bootstrap").removeClass("col-lg-6 col-lg-offset-3 col-lg-10 col-lg-offset-1");
                    $(".welcome-msg").hide();
                    $("#timepicker").css({"margin-left":"0px"});
                    $(".btn-changeview").css({"font-size":"9px"});
                    $(".modal-labels").css({"margin-top":"5px","margin-bottom":"11px"});
                    $("#timepicker").css({"margin-bottom":"-4px"});
                    $("#title").css({"margin-bottom":"-4px"});
                    $(".manage-classes").hide();
                }
                else if (windowWidth < 1170) {

                    $('#calendar').fullCalendar('changeView', 'agendaWeek');
                    $("h2").css("fontSize", "20px");
                    $("#calendar").fullCalendar('option', 'height', 600);
                    $("#cal-bootstrap").addClass("col-lg-12");
                    $("#cal-bootstrap").removeClass("col-lg-6 col-lg-offset-3 col-lg-10 col-lg-offset-1");
                    $(".welcome-msg").show();
                    $("#timepicker").css({"margin-left":"-12px"});
                    $(".btn-changeview").css({"font-size":"9px"});
                    $(".modal-labels").css({"margin-top":"0px","margin-bottom":"0px"});
                    $(".manage-classes").hide();
                }
                else if (windowWidth < 1600) {

                    if($autoresize)
                        $('#calendar').fullCalendar('changeView', 'month');

                    $("h2").css("fontSize", "20px");
                    $("#calendar").fullCalendar('option', 'height', 800);
                    $("#cal-bootstrap").addClass("col-lg-10 col-lg-offset-1");
                    $("#cal-bootstrap").removeClass("col-lg-6 col-lg-offset-3 col-lg-12");
                    $(".welcome-msg").show();
                    $("#timepicker").css({"margin-left":"0px"});
                    $(".btn-changeview").css({"font-size":"9px"});
                    $(".modal-labels").css({"margin-top":"0px","margin-bottom":"0px"});
                    $(".manage-classes").show();
                }
                else {

                    if($autoresize)
                        $('#calendar').fullCalendar('changeView', 'month');

                    $("h2").css("fontSize", "20px");
                    $("#calendar").fullCalendar('option', 'height', 800);
                    $("#cal-bootstrap").addClass("col-lg-6 col-lg-offset-3");
                    $("#cal-bootstrap").removeClass("col-lg-10 col-lg-offset-1 col-lg-12");
                    $(".welcome-msg").show();
                    $("#timepicker").css({"margin-left":"0px"});
                    $(".btn-changeview").css({"font-size":"14px"});
                    $(".modal-labels").css({"margin-top":"0px","margin-bottom":"0px"});
                    $(".manage-classes").show();
                }
            }

            $("#timepicker").timepicker({
                'step': 15,
                'forceRoundTime': true,
                'noneOption': [
                    {
                        'label': 'All Day',
                        'value': 'All Day'
                    }
                ]
            });

            $("#btn-week").click(function() {
                $('#calendar').fullCalendar('changeView', 'agendaWeek');
                $autoresize = false;
            });

            $("#btn-day").click(function() {
                $('#calendar').fullCalendar('changeView', 'agendaDay');
                $autoresize = false;
            });

            $("#btn-month").click(function() {
                $('#calendar').fullCalendar('changeView', 'month');
                $autoresize = false;
            });

            $("#btn-add-class-navbar").click(function() {
                $("#newClass").hide();
                $("#classesModal").modal();
            });


            $(".form-control").keypress(function (event) {
                if (event.which == 13) {
                    event.preventDefault();
                    $("#submit").click();
                }
            });

            $("#modal-form").submit(function(e) {
                e.preventDefault();

                var $date = $("#due_date").val();
                var $time = $("#timepicker").val();

                alert($date);
                alert($time);

                if ($time == "All Day"){
                    $("#all_day").val("1");
                    var $newTime = $date + " 00:00:00";
                }
                else {
                    $("#all_day").val("0");
                    var $newTime = $date + " " + $time;
                }

                alert($newTime);


                $("#due_date").val(moment($newTime, "YYYY-MM-DD hh:mma").format("YYYY-MM-DD HH:mm:ss"));

                alert($("#due_date").val());

                alert($("#modal-form").attr("action"));

                $.post($("#modal-form").attr("action"), $("#modal-form").serialize(), function(){

                        $("#addHomeworkModal").modal('hide');
                        $("#calendar").fullCalendar('refetchEvents');
                });
            });

            $(".delete-btn").click(function(){

//                $date = $("#due_date").val();
//                $time = $("#timepicker").val();
//
//                $newTime = $date + " " + $time;
//                $("#due_date").val(moment($newTime, "YYYY-MM-DD hh:mma").format("YYYY-MM-DD HH:mm:ss"));


                $.post("deleteHomework.php", $("#modal-form").serialize(), function(){

                    $("#addHomeworkModal").modal('hide');
                    $("#calendar").fullCalendar('refetchEvents');
                });

            });

            $(".add-class-button").click(function(){
                $("#newClass").show();
            });

            $(".btn-save-sm").click(function(e){
                e.preventDefault();

                $(".btn-trash-sm").css({"margin-top":"-5px"});

                $.post("addClass.php", $("#new-class-form").serialize(), function(){
    //                    alert("done!");
//                        $("#newClass").hide();
                        location.reload();

                });
            });

            $(".btn-modify-sm").click(function(e){
                e.preventDefault();

                var $buttonClicked = $(this).attr("id");
                var $year, $class_num, $class_name, $instructor_name, $color;

                var $class_id = $buttonClicked.substr(10);

                $year = $(".year-form" + $class_id).val();
                $class_num = $(".class-num-form" + $class_id).val();
                $class_name = $(".class-name-form" + $class_id).val();
                $instructor_name = $(".instructor-name-form" + $class_id).val();
                $color = $(".color-form" + $class_id).val();

//                alert($year);
//                alert($class_num);
//                alert($class_name);
//                alert($instructor_name);
//                alert($color);

                $.post("modifyClass.php", {
                    "class_id":$class_id,
                    "year":$year,
                    "class_num":$class_num,
                    "class_name":$class_name,
                    "instructor_name":$instructor_name,
                    "color":$color


                },

                function(){

                    location.reload();

                });
            });

            $("#btn-trash-dismiss").click(function(e){
               $("#newClass").hide();
            });
        });

    </script>
    <!--[if IE]>
          <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
     <![endif]-->
</head>

<body>

    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--                <img src="boonLogo.png" class="boon-logo-navbar">-->
                <a class="navbar-brand logo-navbar">Boondoggle</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="welcome-msg active"><a>Dashboard</a>
                    </li>
                    <li><a id="btn-add-class-navbar" class="welcome-msg manage-classes"><span class="glyphicon glyphicon-cog"></span> Manage Classes</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="welcome-msg"><a>Welcome, <?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></a>
                    </li>
                    <li class="active"><a href="logout.php">Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="cal-bootstrap" class="col-md-12 col-lg-6 col-lg-offset-3">
                <div class="panel panel-primary calendar-panel">
                    <div class="panel-body calendar-body" id="calendar">

                    </div>
                </div>
            </div>
            <div id="cal-viewchange" class="col-lg-1 hidden-md hidden-sm hidden-xs">
                <div class="panel panel-primary" id="cal-viewchange-panel">
                    <div class="panel-heading" id="cal-viewchange-heading">
                        View
                    </div>
                    <div class="panel-body" id="cal-viewchange-body">
                        <button type="button" class="btn-changeview" id="btn-month">MONTH</button><br />
                        <button type="button" class="btn-changeview" id="btn-week">WEEK</button><br />
                        <button type="button" class="btn-changeview" id="btn-day">DAY</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="addHomeworkModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" id="modal-form" action="addHomework.php" method="post" role="form">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" id="closex">&times;</span><span class="sr-only"></span>
                </button>
                <h4 class="modal-title" id="date-title"></h4>
<!--                <input id="timepicker" type="text" class="time ui-timepicker-input form-control"></input>-->
                <textarea class="form-control" id="year" name="year" readonly></textarea>
            </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label for="class" class="col-sm-3 col-xs-12 control-label"><span class="label label-boondoggle">Class:</span></label>
                        <div class="col-sm-5 col-xs-12">
                            <select class="form-control modal-labels" id="class-select" name="class_id">
                                <option value='0'>None</option>
                                <?php
                                    //open database connection
                                    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
                                    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);

                                    $query = "select class_id, instructor_name, year, class_name,
                                            class_num, color, user_id from class WHERE user_id = " . $_SESSION['user_id'];
                                    $result = mysql_query($query);

                                    if(!$result){
                                        print "Error: Query cannot be processed: ";
                                        $error = mysql_error();
                                        print "$error";
                                        exit;
                                    }

                                    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                        if($row['class_id'] != '0'){
                                            echo "<option value='" . $row['class_id'] . "'>" . $row['class_num'] . " - " . $row['class_name'] . "</option>";
                                        }
                                    }
?>
                            </select>
                        </div>

                        <label for="title" class="col-sm-2 col-xs-12 control-label"><span class="label label-boondoggle">Time Due:</span></label>
                        <div class="col-sm-2 col-xs-12">
                            <input id="timepicker" type="text" class="time ui-timepicker-input form-control modal-labels" name="due_time"></input>

                            </div>
                        </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label"><span class="label label-boondoggle">Title:</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <input type="textarea" class="form-control modal-labels" name="title" id="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 col-xs-12 control-label" id="label-boon"><span class="label label-boondoggle">Description:</span></label>
                        <div class="col-sm-9 col-xs-12">
                            <textarea rows="4" class="form-control modal-labels" name="description" id="description"></textarea>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="event_id" id="event_id">
                    <input type="hidden" class="form-control" name="due_date" id="due_date">
                    <input type="hidden" class="form-control" name="all_day" id="all_day">
                </div>
                <div class="modal-footer">
                    <div class="col-sm-3 col-xs-12">
                        <button type="button" class="btn btn-default close-btn delete-btn"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                    </div>
                    <div class="col-sm-4 col-sm-offset-5 col-xs-12">
                        <button type="submit" class="btn btn-default submit" id="submit"></button>
                    </div>

                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- /.modal -->

<div class="modal fade" id="classesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" id="closex">&times;</span><span class="sr-only"></span>
                </button>
                <h4 class="modal-title">Manage Classes</h4>
            </div>

                <div class="modal-body">
                    <div class="table-responsive">
                         <form method="post" role="form" class="classbtn" id="new-class-form">
                        <table class="table table-bordered" id="class-table">
                                <tr>
                                    <th>Year</th>
                                    <th>Class Number</th>
                                    <th>Class Name</th>
                                    <th>Instructor Name</th>
                                    <th>Color</th>
                                    <th>Options</th>
                                </tr>
                                <?php
                                    //open database connection
                                    $conn = mysql_connect('localhost','c2230a09','c2230a09') or trigger_error("SQL", E_USER_ERROR);
                                    $db = mysql_select_db('c2230a09proj',$conn) or trigger_error("SQL", E_USER_ERROR);

                                    $query = "select class_id, instructor_name, year, class_name,
                                            class_num, color, user_id from class where class_id != 0 AND user_id = " . $_SESSION['user_id'];
                                    $result = mysql_query($query);

                                    if(!$result){
                                        print "Error: Query cannot be processed: ";
                                        $error = mysql_error();
                                        print "$error";
                                        exit;
                                    }


                                    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                        if($row['class_id'] != '0'){
                                            echo "
                                                <tr>
                                                    <td class='td-class td-class-year'>
                                                        <div class='form-group form-class'>
                                                                <textarea rows='4' class='form-control year-form" . $row['class_id'] . "' name='year' id='class-year'>" . $row['year'] . "</textarea>
                                                        </div>
                                                    </td>
                                                    <td class='td-class td-class-num'>
                                                        <div class='form-group form-class'>
                                                                <textarea rows='4' class='form-control class-num-form" . $row['class_id'] . "' name='class_num' id='class-number'>" . $row['class_num'] . "</textarea>
                                                        </div>
                                                    </td>
                                                    <td class='td-class td-class-name'>
                                                        <div class='form-group form-class'>
                                                                <textarea rows='4' class='form-control class-name-form" . $row['class_id'] . "' name='class_name' id='class-name'>" . $row['class_name'] . "</textarea>
                                                        </div>
                                                    </td>
                                                    <td class='td-class td-class-instructor-name'>
                                                        <div class='form-group form-class'>
                                                                <textarea rows='4' class='form-control instructor-name-form" . $row['class_id'] . "' name='instructor_name' id='class-instructor-name'>" . $row['instructor_name'] . "</textarea>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class='form-group form-class'>
                                                            <select id='" . substr($row['color'], 1) . "' name='color' class='color-form" . $row['class_id'] . "' >
                                                                <option value='#55BFAA' data-color='#55BFAA'></option>
                                                                <option value='#F66E81' data-color='#F66E81'></option>
                                                                <option value='#3271ba' data-color='#3271ba'></option>
                                                                <option value='#d39f5b' data-color='#d39f5b'></option>
                                                                <option value='#FFDB72' data-color='#FFDB72'></option>
                                                                <option value='#6A6CC9' data-color='#6A6CC9'></option>
                                                                <option value='#D861AC' data-color='#D861AC'></option>
                                                                <option value='#c96a6a' data-color='#c96a6a'></option>
                                                                <option value='#6ac992' data-color='#6ac992'></option>
                                                                <option value='#8e4242' data-color='#8e4242'></option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class='options-td'>
                                                        <div id='optionscontainer'>

                                                                <input type='hidden' class='form-control' name='class_id' value=" . $row['class_id'] . "></input>
                                                                <button type='submit' class='btn-trash-sm' value='DELETE' formaction='deleteClass.php'><span class='glyphicon glyphicon-trash'>                                                                         </span></button>
                                                                <button type='submit' class='btn-modify-sm' value='MODIFY' formaction='modifyClass.php' id='class-form" .  $row['class_id'] . "'>Save Changes</button>

                                                        </div>
                                                    </td>
                                                    <script>$(document).ready(function(){
                                                                $('#" . substr($row['color'], 1) . "').colorselector();
                                                                $('#" . substr($row['color'], 1) . "').colorselector('setColor', '" . $row['color'] . "');
                                                            });
                                                    </script>
                                                </tr>";
                                        }
                                    }
                                    mysql_close($conn);
                                ?>

                                <tr id="newClass">


                                        <td class="td-class td-class-year">
                                            <div class="form-group form-class">
                                                    <textarea rows="4" class="form-control" name="year" id="class-year"></textarea>
                                            </div>
                                        </td>
                                        <td class="td-class td-class-num">
                                            <div class="form-group form-class">
                                                    <textarea rows="4" class="form-control" name="class_num" id="class-number"></textarea>
                                            </div>
                                        </td>
                                        <td class="td-class td-class-name">
                                            <div class="form-group form-class">
                                                    <textarea rows="4" class="form-control" name="class_name" id="class-name"></textarea>
                                            </div>
                                        </td>
                                        <td class="td-class td-class-instructor-name">
                                            <div class="form-group form-class">
                                                    <textarea rows="4" class="form-control" name="instructor_name" id="class-instructor-name"></textarea>
                                            </div>
                                        </td>
                                        <td class="td-class">
                                            <div class="form-group form-class">
                                                <select id="new-colorselector" name="color">
                                                    <option value="#55BFAA" data-color="#55BFAA"></option>
                                                    <option value="#F66E81" data-color="#F66E81"></option>
                                                    <option value="#3271ba" data-color="#3271ba"></option>
                                                    <option value="#d39f5b" data-color="#d39f5b"></option>
                                                    <option value="#FFDB72" data-color="#FFDB72"></option>
                                                    <option value="#6A6CC9" data-color="#6A6CC9"></option>
                                                    <option value="#D861AC" data-color="#D861AC"></option>
                                                    <option value="#c96a6a" data-color="#c96a6a"></option>
                                                    <option value="#6ac992" data-color="#6ac992"></option>
                                                    <option value="#8e4242" data-color="#8e4242"></option>
                                                </select>
                                            </div>
                                        </td>

                                        <td class="options-td">
                                            <div id='optionscontainer'>
                                                <div id="trashcontainer">
                                                    <button type='button' id='btn-trash-dismiss' class='btn-trash-sm'><span class='glyphicon glyphicon-trash'></span></button>
                                                </div>
                                                <div id="submitcontainer">
                                                        <input type='hidden' class='form-control' name='entry' value=" . $row['class_id'] . "></input>
                                                        <button type='submit' class="btn-save-sm" value='add'><span class="glyphicon glyphicon-plus"></span> Add Class</button>
                                                </div>
                                            </div>
                                        </td>

                            </tr>

                            </table>
            </form>
                            <button type="button" class="add-class-button">New Class</button>
                        </div>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</body>

</html>
