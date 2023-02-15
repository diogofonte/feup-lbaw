const fstname = document.querySelector("#first_name");
const lstname = document.querySelector("#last_name");
const pswrd_1 = document.querySelector("#password1");
const pswrd_2 = document.querySelector("#password2");
const email = document.querySelector("#email1");
const errorText = document.querySelector(".error-text");
const btn = document.querySelector(".reg");

btn.onclick = function(){
  if(fstname.value.length == 0){
    errorText.style.display = "block";
    errorText.classList.remove("matched");
    errorText.textContent = "Error! First name not entered.";
    return false;
  } else {
    if(!(/^[A-Za-z\s]+$/.test(fstname.value))){
      errorText.style.display = "block";
      errorText.classList.remove("matched");
      errorText.textContent = "Error! First name can't have numbers.";
      return false;
    } else {
      if(lstname.value.length == 0){
        errorText.style.display = "block";
        errorText.classList.remove("matched");
        errorText.textContent = "Error! Last name not entered.";
        return false;
      } else {
        if(!isNaN(lstname.value)){
          errorText.style.display = "block";
          errorText.classList.remove("matched");
          errorText.textContent = "Error! Last name can't have numbers.";
          return false;
        } else {
          if(email.value.length == 0){
            errorText.style.display = "block";
            errorText.classList.remove("matched");
            errorText.textContent = "Error! Email not entered.";
            return false;
          } else {
            if(pswrd_1.value.length == 0){
              errorText.style.display = "block";
              errorText.classList.remove("matched");
              errorText.textContent = "Error! Password not entered.";
              return false;
            } else {
              if(pswrd_2.value.length == 0){
                errorText.style.display = "block";
                errorText.classList.remove("matched");
                errorText.textContent = "Error! Confirm password not entered.";
                return false;
              } else {
                if(pswrd_1.value != pswrd_2.value){
                  errorText.style.display = "block";
                  errorText.classList.remove("matched");
                  errorText.textContent = "Error! Confirm Password not match.";
                  return false;
                } else {
                  errorText.style.display = "block";
                  errorText.classList.add("matched");
                  return true;
                }
              }
            }
          }
        }
      }
    }
  }
}
         
