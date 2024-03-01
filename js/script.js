function validateSignup(event){
    event.preventDefault()
     let fname = document.getElementById("fname").value
     let lname = document.getElementById("lname").value
     let email = document.getElementById("email").value
     let pwd = document.getElementById("pwd").value
     let gender = document.getElementById("radioMale").value

     const data = {
         emri : fname,
         mbiemri : lname,
         emaili : email,
         passwordi : pwd,
         gjinia : gender
     }
     console.log(data)
 }


 