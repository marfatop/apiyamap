window.addEventListener('load', function (e) {

  document.querySelectorAll('[name="street"]').forEach(function (el, indx) {
    el.addEventListener('input', async (e) => {

      let street_name=el.value

if(street_name.length>3){
  let data = {
    adress: street_name,
    task:'getKladr'
  }
  let url = '/controllers/ajax.php'
  let response = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'data='+JSON.stringify(data)
  })

  let result = await response.json();
  let eladd_res=document.getElementById("address")
  eladd_res.innerHTML=""
  let json=JSON.parse(result)

  console.log(json)

  let html=""

  Object.entries(json.result).forEach(([key, value]) => {
    html+="<p>"+value["name"]+"</p>"
  })

  eladd_res.innerHTML=html
  console.log(json['result'])
}
    })
  })
})