window.addEventListener('load', function (e){

  let json_api= {"name":"Grow, Timo, Krusl, henry, Groof, Goody"}

  if(json_api.name.indexOf('Krusl')>=0){
    console.log('Krusl')
  }
  else if(json_api.name.indexOf('Goody')>=0){
    console.log('Goody')
  }
  else{
    console.log('Ничего не нашел')
  }

})