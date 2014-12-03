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
    <link rel="shortcut icon" href="favicon.ico" />
    <script>
$(document).ready(function () {

    //var to store whether a view button has been selected (if it has, then disable autoresize for larger resolutions)
    var $autoresize = true;

    //initialize fullCalendar on the div with the id calendar.
    $('#calendar').fullCalendar({
        //define options for the header of the calendar
        header: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        //set events editable to false (this prevents dragging/moving of events)
        editable: false,
        //set initial height to 800px;
        height: 800,
        //generate events from loadEvents.php, a file that echos JSON of the db's events
        events: 'loadEvents.php',
        //through eventRender, qtip2 tooltips will be attached.
        eventRender: function (event, element) {
            //on each element being rendered, attach a qtip...
            element.qtip({
                //with the content of:
                content: {
                    //set qtip's title to:
                    title:  function() {
                                //if the event has a class tied to it...
                                if (event.class_num !== "")  {
                                    //display class number, class name, and instructor name.
                                    return event.class_num + ' - ' + event.class_name + '<br />' +
                                    event.instructor_name;
                                }
                                //else...
                                else {
                                    //display No Class Defined.
                                    return "No Class Defined";
                                }
                            },
                    //set qtip's text to:
                    text:   function() {
                                //if the event has a title...
                                if (event.title !== "")  {
                                    //display the title with the description
                                    return event.title + '<br />' +
                                    event.description;
                                }
                                //otherwise display No Title with the description
                                else {
                                    return "No Title" + '<br />' + event.description;
                                }
                            }
                },
                //display the qtip at mouseover
                show: 'mouseover',
                //at the qtip's bottom center and the element's top center.
                position: {
                    my: 'bottom center',
                    at: 'top center'
                },

            });
        },
        //this limits the amount of events that can be displayed on each day.
        eventLimit: true,
        //this makes it where if the events reach the limit, you can press a button that will show them on popover.
        eventLimitClick: "popover",
        //and this makes that button's text 'more'.
        eventLimitText: "more",
        //this triggers whenever a day is clicked.
        dayClick: function (date, jsEvent, view) {
            //set the modal's title to the day's date.
            $("#date-title").html(date.format("dddd, MMMM Do"));
            //set the modal's hidden field due_date to the day's date.
            $("#due_date").val(date.format("YYYY-MM-DD"));
            //set the modal's year to the day's year.
            $("#year").html(date.format("YYYY"));
            //set the class dropdown to none.
            $("#class-select").val(0);
            //hide the delete button that is used on eventClick.
            $(".delete-btn").hide();
            //change the form's action to addHomework.
            $("#modal-form").attr("action", "addHomework.php");
            //change the submit button's text to Add Homework.
            $(".submit").html("Add Homework");
            //empty out all the fields.
            $("#title").val("");
            $("#description").val("");
            //set the timepicker's time to the time of the dayClick.
            $("#timepicker").timepicker('setTime', date.format("h:mma"));

            //and show the prepared modal.
            $("#addHomeworkModal").modal();
        },
        //set default eventColor.
        eventColor: '#336282',
        //this triggers whenever an event is clicked.
        eventClick: function (calEvent, jsEvent, view) {
            //set the title of the modal to the event's date.
            $("#date-title").html(calEvent.start.format("dddd, MMMM Do"));
            //set the hidden field event_id to the event's id.
            $("#event_id").val(calEvent.id);
            //set the hidden field due_date to the event's date.
            $("#due_date").val(calEvent.start.format("YYYY-MM-DD"));
            //set the title field to the event's title.
            $("#title").val(calEvent.title);
            //select the event's class in the dropdown menu.
            $("#class-select").val(calEvent.class_id);
            //set the modal's year to the event's year.
            $("#year").html(calEvent.start.format("YYYY"));
            //set the description textarea to the event's description.
            $("#description").val(calEvent.description);
            //show the delete button.
            $(".delete-btn").show();
            //set the action of the form to modifyHomework.
            $("#modal-form").attr("action", "modifyHomework.php");
            //set the text of the submit button to Save Changes.
            $(".submit").html("Save Changes");
            //set the timepicker's time to the time of the event.
            $("#timepicker").timepicker('setTime', calEvent.start.format("h:mma"));

            //and show the prepared modal.
            $("#addHomeworkModal").modal();
        }
    });

    //this code assigns the css class qtip to all qtip objects.
    $('.selector').qtip({
        style: {
            classes: 'qtip'
        }
    });

    //this is a roundabout way of turning spellcheck off of all textareas.
    $("input[type='text'], textarea").attr('spellcheck',false);

    //initialize the color selector in the homework modal.
    $("#new-colorselector").colorselector();

    //initially resize the calendar.
    resizeCalendar();

    //and every time the window is resized...
    $(window).resize(function () {
        //resize the calendar.
        resizeCalendar();

    });

    //function to resize the calendar responsively
    function resizeCalendar() {
        //first, get the current window width.
        var windowWidth = $(window).width();
        //and get the window height.
        var windowHeight = $(window).height();
        //this is the height we will make the calendar if the width is below 1170px.
        var newHeight = windowHeight - 150;

        //and don't let this height go below 400.
        if (newHeight < 400){
            newHeight = 400;
        }

        //if it's less than 600px...
        if (windowWidth < 600) {
            //set calendar's height to newHeight.
            $("#calendar").fullCalendar('option', 'height', newHeight);
            //change the font size of the view panel.
            $(".btn-changeview").css({"font-size":"9px"});
            //change the calendar view to agendaDay.
            $('#calendar').fullCalendar('changeView', 'agendaDay');
            //change the timepicker's left margin.
            $("#timepicker").css({"margin-left":"0px"});
            //change the margins of the modal labels.
            $(".modal-labels").css({"margin-top":"5px","margin-bottom":"11px"});
            //change the bottom margin of the timepicker.
            $("#timepicker").css({"margin-bottom":"-4px"});
            //change the bottom margin of the modal title.
            $("#title").css({"margin-bottom":"-4px"});
            //hide the option to manage classes.
            $(".manage-classes").hide();
            //and hide the welcome msg. (Welcome, user!)
            $(".welcome-msg").hide();

            //if it's less than 350px...
            if (windowWidth < 350){
                //change the font-size and margin of the header title.
                $(".fc-center > h2").css("fontSize", "16px");
                $(".fc-center > h2").css("marginTop", "3px");
            }
            else {
                //change the font-size and margin of the header title.
                $(".fc-center > h2").css("fontSize", "20px");
                $(".fc-center > h2").css("marginTop", "0px");
            }
        }
        //else if it's less than 768px...
        else if (windowWidth < 768) {
            //change the calendar view to agendaWeek.
            $('#calendar').fullCalendar('changeView', 'agendaWeek');
            //and change the font-size of the header title.
            $("h2").css("fontSize", "20px");
            //set calendar's height to newHeight.
            $("#calendar").fullCalendar('option', 'height', newHeight);
            //add the class col-lg-12 to the calendar so it'll be full width at this resolution.
            $("#cal-bootstrap").addClass("col-lg-12");
            //and remove the other lg classes.
            $("#cal-bootstrap").removeClass("col-lg-6 col-lg-offset-3 col-lg-10 col-lg-offset-1");
            //hide the welcome msg. (Welcome, user!)
            $(".welcome-msg").hide();
            //change the left margin of the timepicker.
            $("#timepicker").css({"margin-left":"0px"});
            //change the font of the view change buttons.
            $(".btn-changeview").css({"font-size":"9px"});
            //change the margins of the modal labels.
            $(".modal-labels").css({"margin-top":"5px","margin-bottom":"11px"});
            //change the bottom margin of the timepicker.
            $("#timepicker").css({"margin-bottom":"-4px"});
            //change the bottom margin of the calendar title.
            $("#title").css({"margin-bottom":"-4px"});
            //and hide the manage classes button on the navbar.
            $(".manage-classes").hide();
        }
        //else if it's less than 1170px...
        else if (windowWidth < 1170) {
            //change the calendar's view to agendaWeek
            $('#calendar').fullCalendar('changeView', 'agendaWeek');
            //change the calendar title's fontsize to 20px.
            $("h2").css("fontSize", "20px");
            //set calendar's height to newHeight.
            $("#calendar").fullCalendar('option', 'height', newHeight);
            //add the class col-lg-12 to the calendar so it'll be full width at this resolution.
            $("#cal-bootstrap").addClass("col-lg-12");
            //and remove the other lg classes.
            $("#cal-bootstrap").removeClass("col-lg-6 col-lg-offset-3 col-lg-10 col-lg-offset-1");
            //show the welcome msg in the navbar.
            $(".welcome-msg").show();
            //change the left margin of the timepicker.
            $("#timepicker").css({"margin-left":"-12px"});
            //change the font size of the change view buttons.
            $(".btn-changeview").css({"font-size":"9px"});
            //change the margins of the modal labels.
            $(".modal-labels").css({"margin-top":"0px","margin-bottom":"0px"});
            //and hide the manage classes button on the navbar.
            $(".manage-classes").hide();
        }
        //else if it's less than 1600px...
        else if (windowWidth < 1600) {
            //if autoresize is still on (meaning no change view buttons have been pressed)...
            if($autoresize){
                //change the calendar view to month.
                $('#calendar').fullCalendar('changeView', 'month');
            }
            //change the calendar title's fontsize to 20px.
            $("h2").css("fontSize", "20px");
            //set calendar's height to 800.
            $("#calendar").fullCalendar('option', 'height', 800);
            //add the classes col-lg-10 and col-lg-offset-1 so the calendar will take up 10/12 and will be offset by 1.
            $("#cal-bootstrap").addClass("col-lg-10 col-lg-offset-1");
            //remove the other lg classes.
            $("#cal-bootstrap").removeClass("col-lg-6 col-lg-offset-3 col-lg-12");
            //show the welcome msg in the navbar.
            $(".welcome-msg").show();
            //reset the left margin of the timepicker.
            $("#timepicker").css({"margin-left":"0px"});
            //change the fontsize of the change view buttons.
            $(".btn-changeview").css({"font-size":"9px"});
            //change the margins of the modal labels.
            $(".modal-labels").css({"margin-top":"0px","margin-bottom":"0px"});
            //and show the manage classes button in the navbar.
            $(".manage-classes").show();
        }
        //else...
        else {
            //if autoresize is still on (meaning no change view buttons have been pressed)...
            if($autoresize){
                //change the calendar view to month.
                $('#calendar').fullCalendar('changeView', 'month');
            }
            //change the calendar title's fontsize to 20px.
            $("h2").css("fontSize", "20px");
            //set calendar's height to 800.
            $("#calendar").fullCalendar('option', 'height', 800);
            //add the classes col-lg-6 and col-lg-offset-3 so the calendar will take up 6/12 and will be offset by 3.
            $("#cal-bootstrap").addClass("col-lg-6 col-lg-offset-3");
            //remove the other lg classes.
            $("#cal-bootstrap").removeClass("col-lg-10 col-lg-offset-1 col-lg-12");
            //show the welcome msg in the navbar.
            $(".welcome-msg").show();
            //change the left margin of the timepicker.
            $("#timepicker").css({"margin-left":"0px"});
            //change the fontsize of the change view buttons.
            $(".btn-changeview").css({"font-size":"14px"});
            //change the margins of the modal labels.
            $(".modal-labels").css({"margin-top":"0px","margin-bottom":"0px"});
            //and show the manage classes button in the navbar.
            $(".manage-classes").show();
        }
    }

    //initialize the timepicker
    $("#timepicker").timepicker({
        //with 15 min steps
        'step': 15,
        //make sure time entered is rounded to 15s
        'forceRoundTime': true,
        //create label for all day
        'noneOption': [
            {
                'label': 'All Day',
                'value': 'All Day'
            }
        ]
    });

    //click listener for week view button
    $("#btn-week").click(function() {
        //change view to agendaWeek
        $('#calendar').fullCalendar('changeView', 'agendaWeek');
        //and disable autochanging the view in larger resolutions
        $autoresize = false;
    });

    //click listener for day view button
    $("#btn-day").click(function() {
        //change view to agendaDay.
        $('#calendar').fullCalendar('changeView', 'agendaDay');
        //and disable autochanging the view in larger resolutions
        $autoresize = false;
    });

    //click listener for month view button
    $("#btn-month").click(function() {
        //change view to month.
        $('#calendar').fullCalendar('changeView', 'month');
        //and disable autochanging the view in larger resolutions
        $autoresize = false;
    });

    //click listener for manage classes in the navbar
    $("#btn-add-class-navbar").click(function() {
        //hide the fields for newClass
        $("#newClass").hide();
        //show the modal for managing classes.
        $("#classesModal").modal();
    });

    //keypress listener for all form controls
    $(".form-control").keypress(function (event) {
        //if enter is pressed
        if (event.which == 13) {
            //prevent the default action
            event.preventDefault();
            //and submit the form.
            $("#submit").click();
        }
    });

    //submit listener for the add/modify homework modal.
    $("#modal-form").submit(function(e) {
        //prevent the default action.
        e.preventDefault();

        //grab the date value.
        var $date = $("#due_date").val();
        //and the time value.
        var $time = $("#timepicker").val();

        //if time is all day...
        if ($time == "All Day"){
            //set the hidden field all_day to 1 (true)
            $("#all_day").val("1");
            //and add 00:00:00 to the date value.
            var $newTime = $date + " 00:00:00";
        }
        //otherwise...
        else {
            //set the hidden field all_day to 0 (false)
            $("#all_day").val("0");
            //and append the time onto date.
            var $newTime = $date + " " + $time;
        }

        //set the hidden field due_date's value to the newly created time, formatted without am/pm and w/ secs.
        $("#due_date").val(moment($newTime, "YYYY-MM-DD hh:mma").format("YYYY-MM-DD HH:mm:ss"));

        //ajax post the form with the form's serialized data.
        $.post($("#modal-form").attr("action"), $("#modal-form").serialize(), function(){
            //on success..
            //hide the modal
            $("#addHomeworkModal").modal('hide');
            //and refetch the events on the calendar.
            $("#calendar").fullCalendar('refetchEvents');
        });
    });

    //click listener for the delete homework button
    $(".delete-btn").click(function(){
        //ajax post to deleteHomework.php with the serialized form data
        $.post("deleteHomework.php", $("#modal-form").serialize(), function(){

            //and on success...
            //hide the modal
            $("#addHomeworkModal").modal('hide');
            //and refetch the events on the calendar.
            $("#calendar").fullCalendar('refetchEvents');
        });
    });

    //click function for the manage classes navbar button
    $(".add-class-button").click(function(){
        //show the modal to manage classes.
        $("#newClass").show();
    });

    //click listener for the add class button
    $(".btn-save-sm").click(function(e){
        //prevent the default action
        e.preventDefault();

        //ajax post to addClass.php with the serialized data from the form.
        $.post("addClass.php", $("#new-class-form").serialize(), function(){

            //and reload the page
            location.reload();

        });
    });

    //click listener for the modify class button (save changes)
    $(".btn-modify-sm").click(function(e){
        //prevent the default action
        e.preventDefault();

        //var to store the clicked button's ID (this will be in the format of class-formidnum)
        var $buttonClicked = $(this).attr("id");
        //vars for year, class_num, class_name, instructor_name, and color
        var $year, $class_num, $class_name, $instructor_name, $color;

        //strip "class-form" off of id, leaving only the id of the class we're modifying.
        var $class_id = $buttonClicked.substr(10);

        //gather all the values from their respective inputs using the class_id from the submit button.
        $year = $(".year-form" + $class_id).val();
        $class_num = $(".class-num-form" + $class_id).val();
        $class_name = $(".class-name-form" + $class_id).val();
        $instructor_name = $(".instructor-name-form" + $class_id).val();
        $color = $(".color-form" + $class_id).val();

        //ajax post to modifyClass.php
        $.post("modifyClass.php", {
            //POST all of the data we gathered from the inputs
            "class_id":$class_id,
            "year":$year,
            "class_num":$class_num,
            "class_name":$class_name,
            "instructor_name":$instructor_name,
            "color":$color
        },
        //on success...
        function(){
            //reload the page.
            location.reload();

        });
    });

    //click listener for the trash icon on the new class
    $("#btn-trash-dismiss").click(function(e){
        //hide the new class form
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
