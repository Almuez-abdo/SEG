
// Switch Between Login And SignUp

let select = document.querySelectorAll("section h3 span");
select.forEach(function(ele){
    ele.onclick = function(){
        select.forEach(function(ele){
            ele.classList.remove("active");
        });
        this.classList.add("active");

    };

});


    let state = document.querySelector("form .form-group .state");
    // let city = state.value;

    sel_state = function(){
        state.onclick = function(){ 
        let city = (state.value);
        }
        
    }

    
// console.log(city);