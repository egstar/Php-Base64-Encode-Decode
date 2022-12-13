<?php
if (
    isset($_REQUEST["kcode"]) &&
    !is_null($_REQUEST["kcode"]) &&
    isset($_REQUEST["k"])
) {
    if(isset($_REQUEST['kn']) && $_REQUEST['kn'] > 1 ){
    $knum = $_REQUEST['kn'];
    }else{ $knum = 1; }
    $str = $_REQUEST["kcode"];
    if ($_REQUEST["k"] == 0) {
        for( $i =0; $i< $knum; $i++){
            $str = base64_decode($str);
        }
        $newStr = $str;
    } else {
        for( $i =0; $i< $knum; $i++){
            $str = base64_encode($str);
        }
        $newStr = $str;
    }
    echo json_encode($newStr);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta name="description" content="Base64 Encoder/Decoder" />
    <meta name="author" content="Burham Soliman">
    <meta name="keywords" content="Base64, Encoder, Decoder" />
    <title>Base64 hashing tool</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Rubik+80s+Fade&family=Zen+Dots&display=swap');
       html,body { height:100vh;background:linear-gradient(45deg, rgb(245, 209, 209), rgb(195, 240, 195),rgb(196, 196, 240),rgb(240, 221, 169)); }
       * { scrollbar-width:thin; }
       .btn1, .btn2 { display:block; width:max-content; padding:.60rem; font-family: 'Zen Dots', cursive; }
       input[type=radio] {display:none; }
       .radioDiv { display:block;color:white; padding:.09rem; text-align:center; font-size:.85rem; background:rgba(66, 58, 58, 0.685);border-radius:20px; width:max-content; text-align:center; margin:auto; border:5px solid rgba(66, 58, 58, 0.585); }
       .radioDiv label { cursor:pointer; }
       .isSelected { padding-right:1rem;background: rgba(19, 4, 61, 0.685); border-radius:15px 15px 0 0; box-shadow:0px 2px 3px black; border-top:2px solid rgba(19, 4, 61, 0.685); margin:auto;text-align:center; }
       .inputs { display:inline-flex; margin:auto; text-align:center;width:100%;; justify-content:center; align-items:center; margin-top:1rem;}
       #kcode, #kno { text-align:center;background:lightgray;outline:none; width:50%; height:2.9rem; border: 1px solid darkgray;}
       #kno { width:5rem;border-radius:0px 10px 10px 0px; font-size:1rem;}
       label[for=kcode], label[for=kno] { color:white;background:rgba(66, 58, 58, 0.685);border:1px solid darkgray; padding:1rem; border-radius:10px 0px 0px 10px;}
       label[for=kno] { border-radius:0px;}
       #result {
       margin:auto;
       border:1px solid lightgray; 
       border-radius:15px; 
       width:50%; 
       margin-top:1rem;
       min-height:2rem;
       background:rgba(66, 58, 58, 0.385);
       color:white;
       padding:1rem;
       outline:none;
       text-align:center;
       resize:none;
       display:flex;
       justify-content:center;
       align-items:center;
       }
    </style>
  </head>
  <body>
    <div class="radioDiv">
        <div class="btn1 isSelected">
                <label for="scode1">DECODE</label>
                <input id="scode1" type="radio" name="Switcher" value="0" checked />
        </div>
        <div class="btn2">
                <label for="scode2">ENCODE</label>
                <input id="scode2" type="radio" name="Switcher" value="1" />
        </div>
    </div>
    <div class="inputs">
        <label for="kcode" diabled>TEXT</label>
        <input id="kcode" type="text" name="code" placeholder="Insert text" />
        <label for="kno" diabled>Rounds</label>
        <input id="kno" type="number" placeholder="Rounds" value="1" name="code" min="1" max="999" maxlength="3" />
    </div>
    <textarea id="result" rows="2" cols="80" readonly ></textarea>
    <script>
      let sCode;
      let switchers = document.querySelectorAll('input[name=Switcher]')
      let kCode = document.querySelector('#kcode')
      let knumber = document.querySelector('#kno')
      let result = document.querySelector('#result')
      switchers.forEach((switcher) => {
        switcher.addEventListener('change', () => {
          document.querySelector('.isSelected').classList.remove('isSelected')
          sCode = document.querySelector('input[name=Switcher]:checked').value
          document.querySelector('input[name=Switcher]:checked').parentElement.classList.add('isSelected')
          if(document.querySelector('.isSelected').classList.contains('btn1')){
                document.querySelector('.isSelected').style = "border-radius:15px 15px 0 0"
          } else {
                document.querySelector('.isSelected').style = "border-radius:0px 0px 15px 15px"
          }
          
        })
      })
      kCode.addEventListener('keyup', (e) => {
        if (e.keyCode == 13) {
          let data = {
            "kcode": kCode.value,
            "kno": knumber.value
          }
          const xhttp = new XMLHttpRequest()
          xhttp.onload = function() {
            result.value = this.responseText.replaceAll('"', "")
          }
          if (sCode == 1) {
            xhttp.open("GET", './dc.php?k=1&kcode=' + data['kcode'] + '&kn=' + data['kno'])
          } else {
            xhttp.open("GET", './dc.php?k=0&kcode=' + data['kcode'] + '&kn=' + data['kno'])
          }
          xhttp.send();
        }
      })
    </script>
  </body>
</html>