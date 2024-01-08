/* Keyword Suggestions Code Start */

// getting all required elements
const searchWrapper = document.querySelector(".search-input");
const inputBox = searchWrapper.querySelector("input");
const suggBox = searchWrapper.querySelector(".autocom-box");

// if user press any key and release
inputBox.onkeyup = (e)=>{
	// console.log(e.target.value);
	let userData = e.target.value; // user entered data
	let emptyArray = [];
	if (userData) {
		emptyArray = suggestions.filter((data)=>{
		// filtering array value and user char to lowercase and return only those 
		// word/sentc which are starts with user entered word.
			return data.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase());
		})
		// console.log(emptyArray);
		emptyArray = emptyArray.map((data)=>{
			return data = '<li>'+ data +'</li>';
		})
		console.log(emptyArray);
		searchWrapper.classList.add("active"); // Show autocomplete box
		showSuggestions(emptyArray);
		let allList = suggBox.querySelectorAll("li");
		for (let i = 0; i < allList.length; i++) {
			// adding onclick attribute in all li tag
			allList[i].setAttribute("onclick", "select(this)");
		}
	} else {
		searchWrapper.classList.remove("active"); // Hide autocomplete box
	}
}

function select(element) {
	let selectUserData = element.textContent;
	// console.log(selectUserData);
	inputBox.value = selectUserData; // passing the user selected list item data in textfield
	searchWrapper.classList.remove("active"); // Hide autocomplete box
}

function showSuggestions(list) {
	let listData;
	if (!list.length) {
		userValue = inputBox.value;
		listData = '<li>'+ userValue +'</li>';
	} else {
		listData = list.join('');
	}
	suggBox.innerHTML = listData;
}

/* Keyword Suggestions Code End */

/* Party Name Suggestions Code Start */

    var tags = [
    "DY Patil", 
    "Delhi",
    "Ahemdabad",
    "Punjab",
    "Uttar Pradesh",
    "Himachal Pradesh",
    "Karnatka",
    "Kerela",
    "Maharashtra",
    "Gujrat",
    "Rajasthan",
    "Bihar",
    "Tamil Nadu",
    "Haryana"
      ];
  
      /*list of available options*/
     var n= tags.length; //length of datalist tags    
  
     function ac(value) {
        document.getElementById('datalist').innerHTML = '';
         //setting datalist empty at the start of function
         //if we skip this step, same name will be repeated
           
         l=value.length;
         //input query length
     	
     	for (var i = 0; i<n; i++) {
         	if(((tags[i].toLowerCase()).indexOf(value.toLowerCase()))>-1)
         	{
	            //comparing if input string is existing in tags[i] string
	  
	            var node = document.createElement("option");
	            var val = document.createTextNode(tags[i]);
	             node.appendChild(val);
	  
	            document.getElementById("datalist").appendChild(node);
	            //creating and appending new elements in data list
	        }
	    }
     }

/* Party Name Suggestions Code End */;