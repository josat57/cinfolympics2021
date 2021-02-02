/**
 * Cinfolimpics 2021 LOC
 */


$(document).ready(function () {
    selectMenuItems();
    
    $("#btn_teams").click(function (e) {
        $.blockUI({ message: '<img src="../assets/images/loader.gif" style="width:150px; height:80px;" />' + 'Just a moment...' });
        teams(e);
    });
    
    $("#btn_games").click(function (e) {
        $.blockUI({ message: '<img src="../assets/images/loader.gif" style="width:150px; height:80px;" />' + 'Just a moment...' });
        games(e);
    });

    $("#scores-column").click(function (e) {
        getTeams(e);        
        getFixtures(e);
    });

    $("#fixtures-column").click(function (e) {
        getGames(e);
        getTeams(e);
    });

    $("#scores-column").click(function (e) {
        getGames(e);
        getTeams(e);
    });
});

function getTeams(e) {
    // alert(e.target.id);
    e.preventDefault();
    var url = "../../api/routindex.php";    
    $.ajax({
        url: url,
        type: "POST",
        data: {
            "action": "get_teams"
        },
        success: function (res) {
            $.unblockUI();
            var json = JSON.parse(res);
            console.log(json);
            if (json.statuscode == 0) {
                var items = json.data;
                $('#teamScore').html = "";
                $('#firstTeam').html = "";
                $('#secondTeam').html = "";
                $('#thirdTeam').html = "";
                $('#fourthTeam').html = "";
                var placeholder = "Add Inspectors";
                $('#teamScore').text(placeholder);
                console.log(items);
                $('#teamScore').append($('<option>').text("Choose Inspectors to this facility"));
                $.each(items, function(i, obj){
                    console.log(obj.teamName, obj.teamId);
                    $('#teamScore').append($('<option>').text(obj.teamName).attr('value', obj.teamId)).trigger('change');
                    $('#firstTeam').append($('<option>').text(obj.teamName).attr('value', obj.teamId)).trigger('change');
                    $('#secondTeam').append($('<option>').text(obj.teamName).attr('value', obj.teamId)).trigger('change');
                    $('#thirdTeam').append($('<option>').text(obj.teamName).attr('value', obj.teamId)).trigger('change');
                    $('#fourthTeam').append($('<option>').text(obj.teamName).attr('value', obj.teamId)).trigger('change');
                }); 
            } else {
                $.prompt(json.status);
            }
        }
    });
} 

function getGames(e) {
    // alert(e.target.id);
    e.preventDefault();
    var url = "../../api/routindex.php";    
    
    $.ajax({
        url: url,
        type: "POST",
        data: {
            "action": "get_games"
        },
        success: function (res) {
            $.unblockUI();
            var json = JSON.parse(res);
            console.log(json);
            var items = json.data;
            $('#getgame').html = "";
            if (json.statuscode == 0) {
                $.each(items, function (i, obj) {
                    $('#getgame').append($('<option>').text(obj.gameName).attr('value', obj.gameId)).trigger('change');
                });
            } else {
                $.prompt(json.status);
            }
        }
    });
} 

function getFixtures(e) {
    // alert(e.target.id);
    e.preventDefault();
    var url = "../../api/routindex.php";    
    
    $.ajax({
        url: url,
        type: "POST",
        data: {
            "action": "get_fixtures"
        },
        success: function (res) {
            $.unblockUI();
            var json = JSON.parse(res);
            console.log(json);
            if (json.statuscode == 0) {
                var items = json.data;
                $('#fixturescore').html = "";
                var placeholder = "Add Inspectors";
                $('#fixturescore').text(placeholder);
                console.log(items);
                $('#fixturescore').append($('<option>').text("Choose Inspectors to this facility"));
                $.each(items, function(i, obj){
                    console.log(obj.gameName, obj.id);
                    $('#fixturescore').append($('<option>').text(obj.gameName).attr('value', obj.id)).trigger('change');
                }); 
            } else {
                $.prompt(json.status);
            }
        }
    });
} 

function teams(e) {
    // alert(e.target.id);
    e.preventDefault();
    var formData = new FormData(teams_form);
    formData.append("action", "addteam");
    var url = "../../api/routindex.php";    
    
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            $.unblockUI();
            var json = JSON.parse(res);
            console.log(json);
            if (json.statuscode == 0) {
                $.prompt(json.status); 
            } else {
                $.prompt(json.status);
            }
        }
    });
} 

function games(e) {
    // alert(e.target.id);
    e.preventDefault();
    var formData = new FormData(games_form);
    formData.append("action", "addgame");
    var url = "../../api/routindex.php";    
    
    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            $.unblockUI();
            var json = JSON.parse(res);
            console.log(json);
            if (json.statuscode == 0) {
                var items = json.data;
                $('#getgame').html = "";
                var placeholder = "Add Inspectors";
                $('#getgame').text(placeholder);
                console.log(items);
                $('#getgame').append($('<option>').text("Choose Inspectors to this facility"));
                $.each(items, function(i, obj){
                    console.log(obj.gameName, obj.id);
                    $('#getgame').append($('<option>').text(obj.gameName).attr('value', obj.id)).trigger('change');
                }); 
            } else {
                $.prompt(json.status);
            }
        }
    });
} 

function selectMenuItems() {
    var menu = $(".side-menu")[0].children;
    var container = $(".forms-container")[0].children;
    $.each(menu, function (idx, val) {
        $("#" + val.id).click(function () {
            $.each(container, function (nx, cnt) {
                if (cnt.id == val.id+1) {
                    $("#" + cnt.id).css("display", "flex");                    
                } else {
                    $("#" + cnt.id).css("display", "none");
                }
            });
            // console.log(this); 
        });
        // console.log(val);
    });
}

// console.log(menu);
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
      reader.onload = function (e) {
          $('#imgPreview').attr('src', e.target.result);
      };
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

$("#teamlogo").change(function() {
    readURL(this);
    $('#imgPreview').css("display", "flex");
});