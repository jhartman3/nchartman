function onLoad()
{
  getGames();
  //$(".newValue").hide();
}

function ajaxInsertGame(method, Title, Genre, Franchise, Password)
{
  return $.ajax({
    url: 'ShadyAPI.php',
    type: 'POST',
    data: {method: method,
      Title: Title,
      Genre: Genre,
	  Franchise: Franchise,
	  Password: Password
    }
  });
}

function insertGame()
{
  var Title, Genre, Franchise, Password;
  Title = JSON.stringify($('#Title').val());
  Genre = JSON.stringify($('#Genre').val());
  Franchise = JSON.stringify($('#Franchise option:selected').val());
  Password = JSON.stringify($('#Password').val());
  ajax = ajaxInsertGame("insertGame", Title, Genre, Franchise, Password);
  ajax.done(insertGameCallback);
  ajax.fail(function () {
    alert("Please enter the correct password.");
  });
  getGames();
}

function insertGameCallback(response_in)
{
  response = JSON.parse(response_in);
  if (!response['success'])
  {
    $("#results").html("");
    alert("Insert failed on query:" + '\n' + response['querystring']);
  } else
  {
    $("#results").html(response['credentials'] + '<br>' +
            response['querystring'] + '<br>' +
            response['success'] + '<br>');
    getGames();

  }
}

function showGames(Games)
{
  var GameList = "";

  $.each(Games, function (key, value)
  {
    var itemString = "";
    $.each(value, function (key, item)
    {
      itemString += item + "&nbsp &nbsp &nbsp";
    });
    GameList += itemString + '<br>';
  });

  $("#results").html(GameList);
}

function getGames()
{
  var Password = JSON.stringify($('#Password').val());
  ajax = ajaxgetGames("getGames", Password);
  ajax.done(getGamesCallback);
  ajax.fail(function () {
	  alert("Please enter the correct password.");
  });
}

function ajaxgetGames(method, Password)
{

  return $.ajax({
    url: 'ShadyAPI.php',
    type: 'POST',
    data: {method: method,
		Password: Password
    }
  });
}

function getGamesCallback(response_in)
{
  response = JSON.parse(response_in);
  $Games = response["Games"];
  if (!response['success'])
  {
    $("#results").html("getGames failed");
  } else
  {
    $('#Franchise').find('option').remove();
    showGames($Games);
    $.each($Games,
            function (key, Game)
                    /* 
                     * - key is the zero based position in the array
                     * - value is the entire row in the table
                     * - we want the value returned from selecting to be the
                     *   Game id -- position 0 in the row
                     * - we want the value that is displayed in the select
                     *   control to be the Title of the Game -- zero based
                     *   position 2 in the row  Therefore:
                     */
                    {
                      $("#Franchise")
                              .append($('<option>',
                                      {
                                        value: Game[3].toString(),
                                        text: Game[3].toString()
                                      }));

                    }
            )
                    ;
          }
}


function updateGame()
{
  var Title, Genre, Franchise,
      newTitle, newGenre, newFranchise, Password;
  Title = JSON.stringify($('#Title').val());
  Genre = JSON.stringify($('#Genre').val());
  Franchise = JSON.stringify($('#Franchise option:selected').val());
  newTitle = JSON.stringify($('#newTitle').val());
  newGenre = JSON.stringify($('#newGenre').val());
  newFranchise = JSON.stringify($('#newFranchise option:selected').val());
  Password = JSON.stringify($('#Password').val());
  ajax = ajaxupdateGames("updateGame", newTitle, newGenre, newFranchise, Password);
  ajax.done(updateGameCallback);
  ajax.fail(function () {
    alert("Please enter the correct password.");
  });
}

function ajaxupdateGame(method, Password)
{

  return $.ajax({
    url: 'ShadyAPI.php',
    type: 'POST',
    data: {method: method,
		Password: Password
    }
  });
}

function updateGameCallback(response_in)
{
  response = JSON.parse(response_in);
  $Games = response["Games"];
  if (!response['success'])
  {
    $("#results").html("updateGames failed");
  } else
  {
    $("#results").html(response['querystring']);
    $Games = getGames();
    showGames($Games);
  }
}