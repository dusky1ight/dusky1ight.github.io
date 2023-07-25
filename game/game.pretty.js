

let balance = 0;
let numRoundsPlayed = 0;
let total = 0;
var score = 0;
var globalNumDice = 0;
const startButton = document.getElementById("start-button");
const quitButton = document.getElementById("quit-button");
const helpButton = document.getElementById("help-button");
const helplessButton = document.getElementById("helpless-button");
const releaseButton = document.getElementById("Release-button");
const submitButton = document.getElementById("submit-button");
const numDiceInput = document.getElementById("num-dice");
const scoreContainer = document.getElementById("score-container");
const outputContainer = document.getElementById("output-container");
const shoutputContainer = document.getElementById("output-container2");
const diceImage = document.getElementById("dice-image");
const diceContainer = document.getElementById("dice-container");


const imageDes = ["PasaF1.svg","PasaF2.svg","PasaF3.svg","PasaF4.svg","PasaF5.svg","PasaF6.svg"]








startButton.addEventListener("click", () => {
    showInputForm();
});

function showInputForm() {
	const inputForm = document.getElementById("input-form");
	inputForm.style.display = "inline";
  startButton.style.display = "none";
  quitButton.style.display ="none"; 

}



function exitGame(){
 
  outputContainer.innerText = "Kindly note that our browser doesn't allow Scripts to close only the windows that were opened by them. Hence, Close the Tab to exit the page (:";
  outputContainer.style.color="white";
  outputContainer.style.fontSize="69px";
    setTimeout(function() {
    location.reload();
  }, 5000);
}




submitButton.addEventListener("click", e => {

  const input = document.getElementById("num-dice").value;

  const numDice = Number(input) ;
  globalNumDice = numDice;

	if (Number.isInteger(numDice)== false ||isNaN(numDice) || numDice < 3 || numDice > 6) {
		outputContainer.innerText = "Error: Please enter a number between '3' and '6'.";
    outputContainer.style.fontFamily = "tooneynoodle";
    outputContainer.style.color ="white";
    outputContainer.style.fontSize = "50px";
    outputContainer.style.color = "#3f3f3f"
	} else {
		outputContainer.innerText = `Number of dice selected: ${numDice}`;
    outputContainer.style.fontFamily = 'tooneynoodle'
    const inputForm = document.getElementById("input-form");
    inputForm.style.display = "none";
    rollDice();
	}
});



  
function rollDice() {

  numRoundsPlayed++;
  
  nunDice = globalNumDice;
  numDice = globalNumDice;
  // Clear the dice container
  const diceContainer = document.getElementById("dice-container");
  diceContainer.innerHTML = "";
  diceContainer.style.width ="100%";
  diceContainer.style.height="2em";

  let dice = [];

  // Roll each dice and display the corresponding image
  for (let i = 0; i < numDice; i++) {
    // Generate a random number between 1 and 6
    const diceValue = Math.floor(Math.random() * 6) + 1;
    dice.push(diceValue);
    console.log(dice);
    // Create a new dice image element
    const diceImage = document.createElement("img");
    diceImage.src = imageDes[diceValue - 1];
    diceImage.alt = "Dice Image";
    diceImage.classList.add("dice");
    diceImage.style.transitionDelay = `${i * 0.21}s`; // add delay to each dice
    diceImage.style.boxShadow = "5px 5px 5px 10px red"
    diceImage.style.width = "12rem";
    diceImage.style.height = "10rem";
  
    // Add the dice image to the container
    diceContainer.appendChild(diceImage);
  
  
    const shuffleInterval = setInterval(() => {
        const randomValue = Math.floor(Math.random() * 6) + 1;
        diceImage.src = imageDes[randomValue - 1];
      }, 50);
  
      // Trigger the animation after a brief delay
      setTimeout(() => {
        clearInterval(shuffleInterval);
        diceImage.src = imageDes[diceValue - 1];
        diceImage.classList.add("roll");
      }, 300 + i * 100); // add delay to each dice
  
    }  
 // console.log(dice);

  calculateScore(nunDice,dice);
  

}

function calculateScore(nunDice,dice) {

    console.log(nunDice);
    let score = 0;
    let counts = {};
  
    // Count the occurrences of each value in the dice array
  for (let value of dice) {
      counts[value] = (counts[value] || 0) + 1;
    
  
    // Check each scoring criterion in order of priority
      if (Object.values(counts).includes(dice.length)) {
      // All dice have the same value
      score = 60 + dice.reduce((acc, val) => acc + val);
      shoutputContainer.innerText = `Lady Luck is Smiling !!`;
      shoutputContainer.fontSize = "40px";
      shoutputContainer.fontFamily = "PfontDes";
      shoutputContainer.style.color = "white"
    }   else if (Object.values(counts).includes(dice.length - 1)) {
      // N-1 dice have the same value
      score = 40 + dice.reduce((acc, val) => acc + val);
      shoutputContainer.innerText = `Close to JackPot Closer to Having a Great Day !`;
      shoutputContainer.fontSize = "35px";
      shoutputContainer.fontFamily = "PfontDes";
      shoutputContainer.style.color = "white"
    }   else if (Object.keys(counts).length === dice.length && Math.max(...dice) - Math.min(...dice) === dice.length - 1)
    {
      // A run
      score = 20 + dice.reduce((acc, val) => acc + val);
      shoutputContainer.innerText = `Run Forest!! it's a RUN!!!`;
      shoutputContainer.style.fontSize = "69px";
      shoutputContainer.style.fontFamily = "PfontDes";
      shoutputContainer.style.color = "white"
    }   else if(new Set(dice).size === nunDice)
    
    
    {
      // not a run also no values are same
      score = dice.reduce((acc, val) => acc + val);
      shoutputContainer.innerText = `Well Done!!`;
      shoutputContainer.style.fontSize = "40px";
      shoutputContainer.style.fontFamily = "PfontDes";
      shoutputContainer.style.color = "white"
      // console.log(dice);

    }
      // All other cases
        else {
        score = 0;
        // console.log(dice)
        shoutputContainer.innerText = `Not Your Lucky instance! Roll Again ?`;
        shoutputContainer.style.fontSize = "50px";
        shoutputContainer.style.fontFamily = "PfontDes";
        shoutputContainer.style.color = "white"
    }
  }

  //  console.log(score);
    total += score;

   console.log(total);
   // console.log(score);
    console.log(numRoundsPlayed);
   // console.log(nunDice);
    
    outputContainer.innerText = `Number of Rounds played: ${numRoundsPlayed}`;
    outputContainer.style.color = "white"
    scoreContainer.innerText = `You won ${score} in this round!`;
    scoreContainer.style.fontFamily = "tooneynoodle";
    scoreContainer.style.fontSize = '40px';
    scoreContainer.style.color = 'white';
    // shoutputContainer.innerText = `Your Total Score is ${total}`;
    // shoutputContainer.style.fontFamily = 'tooneynoodle';
    // shoutputContainer.style.fontSize = '40px';
    
    helplessButton.style.display = "inline";
    releaseButton.style.display= "inline";
   // console.log(nunDice);
    

}




helpButton.addEventListener("click",()=>{
  window.alert('ladchatt');
  location.reload();
} );


quitButton.addEventListener("click", () => {
	window.close();
});

function quitGame(){

  helplessButton.style.display = "none";
  releaseButton.style.display ="none";

  shoutputContainer.innerText = `Your Total Score for the session is ${total}`;
  shoutputContainer.style.fontFamily = "tooneynoodle";
  outputContainer.style.fontSize = "100px";
  outputContainer.style.color = "red";
  outputContainer.innerText = `Your Average Score per round is ${(total/numRoundsPlayed).toFixed(1)} and Total Number of Rounds Played: ${numRoundsPlayed} `;
  outputContainer.style.fontSize = "60px";
  scoreContainer.innerText = "This window will close Automatically in 15 seconds....";
  scoreContainer.style.fontSize = "80px";
  diceContainer.style.display = "block";

  diceContainer.innerText = " HOPE YOU HAD FUN !! (: ";
  diceContainer.style.color = "white";
  diceContainer.style.fontSize = "100px";
  diceContainer.style.fontFamily = "tooneynoodle";
  
  

  

  setTimeout(function() {
    location.reload();
  }, 15000);



}


