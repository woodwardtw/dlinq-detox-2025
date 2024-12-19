// Add your JS customizations here

//looks for #submit in url to expand submission form

jQuery(document).ready(function() {

  if(window.location.hash == '#submission') {
    jQuery('#submission').modal('show');
  }
  //does it for anchor link to #submission as well
   window.addEventListener('hashchange', function() { 
        if(window.location.hash == '#submission') {
            jQuery('#submission').modal('show');
        }
    });

});


//format AI conversation pastes
const botSection =  document.querySelector('.entry-content');
const allParagraphs = botSection.querySelectorAll('p');
allParagraphs.forEach((p) => {
 const text = p.innerHTML
 const aiCheck = checkForSpeaker(text,'AI: ');
 const personCheck = checkForSpeaker(text,'Human: ');
  if(aiCheck === true){
    p.classList.add('bot');
  }
  if(personCheck === true){
    p.classList.add('human');
  }
  if(personCheck === true || aiCheck === true){
    p.classList.add('convo')
  }
});

function checkForSpeaker(text,lookfor){
  const len = lookfor.length;
  const subString = text.substring(0, len);
  if(subString==lookfor){
    return true;
  }
}