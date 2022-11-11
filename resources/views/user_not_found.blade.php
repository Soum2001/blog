<style>
    body {
  text-align: center;
  margin: 80px auto 0;
  font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
  background: aquamarine;
}

.emoji {
  width: 120px;
  height: 120px;
  margin: 15px 15px 40px;
  background: #ffda6a;
  display: inline-block;
  border-radius: 50%;
  position: relative;
}
.emoji:after {
  position: absolute;
  bottom: -40px;
  font-size: 18px;
  width: 60px;
  left: calc(50% - 30px);
  color: #8a8a8a;
}

.emoji__face,
.emoji__eyebrows,
.emoji__eyes,
.emoji__mouth {
  position: absolute;
}
.emoji__face:before, .emoji__face:after,
.emoji__eyebrows:before,
.emoji__eyebrows:after,
.emoji__eyes:before,
.emoji__eyes:after,
.emoji__mouth:before,
.emoji__mouth:after
{
  position: absolute;
  content: "";
}

.emoji__face {
  width: inherit;
  height: inherit;
}


.emoji--sad .emoji__face {
  -webkit-animation: sad-face 2s ease-in infinite;
          animation: sad-face 2s ease-in infinite;
}
.emoji--sad .emoji__eyebrows {
  left: calc(50% - 3px);
  top: 35px;
  height: 6px;
  width: 6px;
  border-radius: 50%;
  background: transparent;
  box-shadow: -40px 9px 0 0 #000000, -25px 0 0 0 #000000, 25px 0 0 0 #000000, 40px 9px 0 0 #000000;
}
.emoji--sad .emoji__eyebrows:before, .emoji--sad .emoji__eyebrows:after {
  width: 30px;
  height: 20px;
  border: 6px solid #000000;
  box-sizing: border-box;
  border-radius: 50%;
  border-bottom-color: transparent;
  border-left-color: transparent;
  border-right-color: transparent;
  top: 2px;
  left: calc(50% - 15px);
}
.emoji--sad .emoji__eyebrows:before {
  margin-left: -30px;
  transform: rotate(-30deg);
}
.emoji--sad .emoji__eyebrows:after {
  margin-left: 30px;
  transform: rotate(30deg);
}
.emoji--sad .emoji__eyes {
  width: 14px;
  height: 16px;
  left: calc(50% - 7px);
  top: 50px;
  border-radius: 50%;
  background: transparent;
  box-shadow: 25px 0 0 0 #000000, -25px 0 0 0 #000000;
}
.emoji--sad .emoji__eyes:after {
  background: #548dff;
  width: 12px;
  height: 12px;
  margin-left: 6px;
  border-radius: 0 100% 40% 50%/0 50% 40% 100%;
  transform-origin: 0% 0%;
  -webkit-animation: tear-drop 2s ease-in infinite;
          animation: tear-drop 2s ease-in infinite;
}
.emoji--sad .emoji__mouth {
  width: 60px;
  height: 80px;
  left: calc(50% - 30px);
  top: 80px;
  box-sizing: border-box;
  border: 6px solid #000000;
  border-radius: 50%;
  border-bottom-color: transparent;
  border-left-color: transparent;
  border-right-color: transparent;
  background: transparent;
  -webkit-animation: sad-mouth 2s ease-in infinite;
          animation: sad-mouth 2s ease-in infinite;
}
.emoji--sad .emoji__mouth:after {
  width: 6px;
  height: 6px;
  background: transparent;
  border-radius: 50%;
  top: 4px;
  left: calc(50% - 3px);
  box-shadow: -18px 0 0 0 #000000, 18px 0 0 0 #000000;
}

@keyframes wow-brow {
  15%, 65% {
    top: 25px;
  }
  75%, 100%, 0% {
    top: 15px;
  }
}


@-webkit-keyframes sad-face {
  25%, 35% {
    top: -15px;
  }
  55%, 95% {
    top: 10px;
  }
  100%, 0% {
    top: 0;
  }
}
@keyframes sad-face {
  25%, 35% {
    top: -15px;
  }
  55%, 95% {
    top: 10px;
  }
  100%, 0% {
    top: 0;
  }
}
@-webkit-keyframes sad-mouth {
  25%, 35% {
    transform: scale(0.85);
    top: 70px;
  }
  55%, 100%, 0% {
    transform: scale(1);
    top: 80px;
  }
}
@keyframes sad-mouth {
  25%, 35% {
    transform: scale(0.85);
    top: 70px;
  }
  55%, 100%, 0% {
    transform: scale(1);
    top: 80px;
  }
}
@-webkit-keyframes tear-drop {
  0%, 100% {
    display: block;
    left: 35px;
    top: 15px;
    transform: rotate(45deg) scale(0);
  }
  25% {
    display: block;
    left: 35px;
    transform: rotate(45deg) scale(2);
  }
  49.9% {
    display: block;
    left: 35px;
    top: 65px;
    transform: rotate(45deg) scale(0);
  }
  50% {
    display: block;
    left: -35px;
    top: 15px;
    transform: rotate(45deg) scale(0);
  }
  75% {
    display: block;
    left: -35px;
    transform: rotate(45deg) scale(2);
  }
  99.9% {
    display: block;
    left: -35px;
    top: 65px;
    transform: rotate(45deg) scale(0);
  }
}
@keyframes tear-drop {
  0%, 100% {
    display: block;
    left: 35px;
    top: 15px;
    transform: rotate(45deg) scale(0);
  }
  25% {
    display: block;
    left: 35px;
    transform: rotate(45deg) scale(2);
  }
  49.9% {
    display: block;
    left: 35px;
    top: 65px;
    transform: rotate(45deg) scale(0);
  }
  50% {
    display: block;
    left: -35px;
    top: 15px;
    transform: rotate(45deg) scale(0);
  }
  75% {
    display: block;
    left: -35px;
    transform: rotate(45deg) scale(2);
  }
  99.9% {
    display: block;
    left: -35px;
    top: 65px;
    transform: rotate(45deg) scale(0);
  }
}
.mssg{
    margin-top:-9px;
    font-size:100px;
    color:#FF0051;
}
</style>
<div class="emoji emoji--sad">
  <div class="emoji__face">
    
    <div class="emoji__eyebrows"></div>
    <div class="emoji__eyes"></div>
    <div class="emoji__mouth"></div>
    
  </div>
 
</div>
<p class="mssg">User Not Found</p>