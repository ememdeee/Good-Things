var n_img = 2;
var corrente = 1;

function succ(slider){
    corrente++;
    if(corrente > n_img){
        corrente = 1;
    }
  
    for(var i = n_img; i > 0; i--){
        document.querySelector("#img_slider"+slider+" img:nth-child(" + i + ")").style.display = "none";
    }
    document.querySelector("#img_slider"+slider+" img:nth-child(" + corrente + ")").style.display = "block";
}

function prec(slider){
    corrente--;
    if(corrente == 0){
        corrente = n_img;
    }
  
    for(var i = n_img; i > 0; i--){
        document.querySelector("#img_slider"+slider+" img:nth-child(" + i + ")").style.display = "none";
    }
    document.querySelector("#img_slider"+slider+" img:nth-child(" + corrente + ")").style.display = "block";
}