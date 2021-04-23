//DEVELOPER          DATE        COMMENTS
//Gurpreet(1911343)  21/04/2021  Created searchPurchases.js file 
//                               this will use AJAX method to show the purchases for a customer
//                               Created a method to handel all the errors and show as message
//Gurpreet(1911343)  22/04/2021  Added date feature to our call so that we can get result after specific date


//some constants 
const PAGE_SEARCH_PURCHASES = 'search-purchases.php';

//this will show errors if we have any during execution this code 
function handleError(error){
    alert("Something went wrong in JavaScript code: "+error);
}

//this will make a call to our php page which will generate the html code
function searchPurchases(){
    try{
        //variable to make AJAX call
        var xhr = new XMLHttpRequest();
        
        //using POST method and using specific page
        xhr.open("POST", PAGE_SEARCH_PURCHASES);

        //this means we are sending text only not media stuff
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        //this we take the value from our text box
        var searchedDate= document.getElementById('searchDate').value;
        var customer_uuid= document.getElementById('customer_uuid').value;

        //sending info to that page
        xhr.send("searchDate=" + searchedDate+"&customer_uuid="+customer_uuid);
        
        //this will check when its ready and add the result to specific location in the website
        xhr.onreadystatechange = function(){
            //when ajax call complete and without any erros means checking the page load correctly
            if(xhr.readyState == 4 && xhr.status == 200){
                //this will plug the html code returned by the search page
                document.getElementById("purchaseTableContainer").innerHTML = xhr.responseText;
            }
        };
        
    }
    catch(error){   //will call the method to show the error
        handleError(error);
    }
}