
const equipe = document.querySelectorAll('.equipe');
const poule = document.querySelectorAll('.poule');

let draggedItem = null;

for(let i=0; i<equipe.length; i++){
  const item = equipe[i];

  item.addEventListener('dragstart',function (){
    draggedItem = item;
    setTimeout(function(){
      item.style.display = 'none';
    },0)
  });
  item.addEventListener('dragend',function (){
    setTimeout(function(){
      item.style.display = 'block';
      draggedItem = null;
    },0)
  });

  for (var j = 0; j < poule.length; j++) {
    const p = poule[j];
    p.addEventListener('dragover',function(e){
      e.preventDefault();
    });

    p.addEventListener('dragenter',function(e){
      e.preventDefault();
    });

    p.addEventListener('drop',function(){
      this.append(draggedItem);
    });
  }
}
