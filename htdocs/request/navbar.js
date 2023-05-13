/*
example below
------------------------- 
<div class="navbar-header">
    <ul class="navbar-nav nav" id="__navbarlist"></ul> 
    <script type="text/javascript" src="/request/navbar.js" data-insertListID="__navbarlist" data-exclude="/chat/page3.html"></script>
</div>
--------------------------
note
- would work just as well as php or just pre generated code. 
*/

document.addEventListener("DOMContentLoaded", genNavbarPageLi());

/*
- requres doc to be fully loaded before running. ^command above handles it
- functionaly async
*/
function genNavbarPageLi(){
    let this_js = document.currentScript;
    
    //gets file path of the hosting html doc
    //console.log(document.location.href.substring(document.location.href.lastIndexOf('/')+1));

    //if a target element(val) exists
    let val = this_js.getAttribute('data-insertListID');
    if(val !== "undefined" ){
        const root = document.getElementById(val);
        //console.log('val: ' + this_js.getAttribute('data-insertListID') + '\nelement: ' + root);
        fetch("/request/navbarpages.json").then((resp) => 
            resp.json().then((data) => {
                //console.log(data);
                //data.splice(data.indexOf(this_js.getAttribute('src')), 1); //assumes no duplicates // assumes it works (it does not)
                
                //takes host file out of navbar. compares by file path
                if((filt = this_js.getAttribute("data-exclude")).length != 0) {
                    // let regex = new RegExp(filt);
                    //console.log('filt: ' + filt); // + '\nregex:' + regex);
                    // data = data.filter((ele) => {
                    //     return !!!(ele.href.match(regex));//hell -> https://stackoverflow.com/a/7052825
                    // })
                    //regex evil. lose some functionality but works pretty much the same
                    data = data.filter((ele) => {
                        return !!!(ele.href.endsWith(filt));//hell -> https://stackoverflow.com/a/7052825
                    })
                }
                // console.log('FILTERED-------------------');
                // console.log(data);

                //creates html <li> elements for remaning pages
                data.forEach((ele) => {
                    li = document.createElement("li");
                        li.setAttribute('class','nav-item')
                    a = document.createElement("a");
                        a.setAttribute('class','nav-link');
                        a.setAttribute('href',ele.href);
                        a.innerHTML = ele.as;
                    li.append(a);
                    root.append( li );
                });
            })
        );
    } 
    else {console.log('no target element for navbar <li>');}
}