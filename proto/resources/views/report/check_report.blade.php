@extends('heafoo')
@php
    use App\Http\Controllers\QueryController;
    $place = QueryController::getOrt($match);
    $home = QueryController::getHome($match);
    $guest =QueryController::getAway($match);
    $results = QueryController::getResults($match);
    $duelle = QueryController::getDuells($match);
    $firstnameHome1 = QueryController::getNamesD($duelle[0]);
    $lastnameHome1;
    $firstnameHome2;
    $lastnameHome2;



    $teams = QueryController::getTeams(1);
    $staffel = "Dummie";



    

@endphp

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}


/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
</head>     
<div id="containerTeams" style="display:none">
@foreach ($teams as $team)
  $cookie_name = $team -> ID;
  $cookie_val = $team -> name;
  setcookie($cookie_name, $cookie_value);
@endforeach
</div>
<script type ="text/javascript">
var teamSugg = ["Trier","Maint"];
</script>

<script>
public var liga = []; //sql 
public var Mannschaften;
public var GastMannschaft;
var HeimMannschaft;
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;

  // prüfen welche id und entprechen prüfen ob vorgänger gesetzt ist  Liga erst dann Mannschaft
  if(!liga.empty ){
    if(Mannschaften.empty){   
      <?php


$results = DB::select('select m.name from Mannschaft m, Liga l,   where m.liga = l.id and l.name = '$liga'
;', array()); 
Mannschaften = results;
?>
    }
    else{   // Idee: wenn Mannschaften ausgewählt sind, var davon speichern und dann für die Spieler autocomplete machen, hier dafür die arrays erstellen
      if{
     // ID_heim = DB::select('select ID from mannschat where name = heimmannschaft;', array()); 
      // heimvornamen = DB::select('select s.vorname from spieler s,  spieler_mannschaft b where b.mannschaft_id = ID_heim ;', array()); 
      // heimnachnamen = DB::select('select s.nachname from spieler s,  spieler_mannschaft b where b.mannschaft_id = ID_heim ;', array()); 
      }
      if{//gast

      }
    }
  }


  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/


/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("liga"), liga);
autocomplete(document.getElementById("tfHome"), Mannschaften);
autocomplete(document.getElementById("tfAway"), Mannschaften);
autocomplete(document.getElementById("vname11"), heimvorname);// alle anderen auch
</script>



@section('page-content')
    <section >
      <h3 class ="font-bold  text-2xl">Spieleberichtsbogen</h3>
    </section>
    <section  class="mt-10 class=w-6/12">
    <form class="flex flex-col mx-3 mb-6" method="POST" action="{{url('/overview/1')}}">
      @csrf

      <div class="flex mb-4">
      <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Liga:</label>
          <input autocomplete="off" type="text" name="liga" id="liga" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value={{ $home }}>
        </div>
        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="home">Heimverein:</label>
          <input autocomplete="off" type="text" name="tfHome" id="tfHome" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3" value={{ $home }}>
        </div>
        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Gastverein:</label>
          <input type="text" name="tfAway" id="tfAway" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value={{ $guest }}>
        </div>
        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Austragungsort:</label>
          <input type="text" name="tfPlace" id="tfPlace" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value={{ $place }}>
        </div>
        <div class="w-1/4 bg-green-400 h-12">
          <label class="block text-gray-900 text-sm font-bold mb-2 ml-3" for="away">Staffel:</label>
          <input type="text" id="tfStaffel" class="bg-gray-100 text-gray-900  w-full focus:outlie-none border-b-4 border-gray-700 focus:border-green-500 transition duration-500 px-3 pb-3"value={{ $staffel }}>
        </div>
      </div>
      <table class="table-fixed">
        <tr>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Vorname</th>
          <th>Nachname</th>
          <th class ="w-1/24">1. Satz</th>
          <th class ="w-1/24">2. Satz</th>
          <th class ="w-1/24">3. Satz</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
          <th class ="w-4">Heim</th>
          <th class ="w-4">Gast</th>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname11">{{ $firstnameHome1[0]->Vorname }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname11">{{ $firstnameHome1[0]->Nachname }}</td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname12"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname12"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname13"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname13"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname14"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname14"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz11"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz12"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz13"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint11"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint12"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint11"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint12"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point11"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point12"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname23"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname23"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname24"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname24"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz23"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint22"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point21"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point22"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname33"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname33"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname34"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname34"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz133"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint32"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point31"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point32"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname43"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname43"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname44"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname44"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz43"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint42"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point41"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point42"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname53"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname53"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname54"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname54"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz53"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint52"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point51"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point52"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname63"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname63"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname64"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname64"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz63"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint62"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point61"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point62"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname73"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname73"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname74"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname74"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz73"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint72"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point71"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point72"></td>
        </tr>
        <tr class ="border-solid border-b-2 border-black">
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-double border-r-2 border-black" id="nname82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname83"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname83"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="vname84"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="nname84"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="satz82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="satz83"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="sumpoint81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="sumpoint82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="setpoint81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-solid border-r-2 border-black" id="setpoint82"></td>
          <td contenteditable="true" class="bg-gray-100 text-black border-dashed border-r-2 border-black" id="point81"></td>
          <td contenteditable="true" class="bg-gray-100 text-black " id="point82"></td>
        </tr>
      </table>
      <button type="submit" name="submit" value="Senden">Send</button>
     </form>
    </section>
    

   
@endsection