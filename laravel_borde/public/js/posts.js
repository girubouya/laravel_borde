window.addEventListener('load',function(){
    const goodBtn = document.querySelectorAll('.goodBtn');

    goodBtn.forEach(btn=>{
        btn.addEventListener('click',(e)=>{
            e.preventDefault();
            const postId = btn.dataset.id;
            const option = btn.dataset.option;

            data = {
                'option':option,
            };

            //押されている場合
            if(btn.classList.contains('check')){
                fetch(`/unlike/${postId}`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type':'application/json'}, // CSRFトークン対策
                    body: JSON.stringify(data),
                })
                .then(response=>response.json())
                .then(res=>{
                    btn.style.color = '#000000';
                    btn.classList.toggle('check');
                    btn.children[1].innerHTML=`* ${res.goodCount}`
                })
                .catch(error=>{
                    console.log(error);
                });
            }else{

                //urlにたいしてリクエストを送る
                fetch(`/like/${postId}`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type':'application/json'}, // CSRFトークン対策
                    body: JSON.stringify(data),
                })
                .then(response=>response.json())
                .then(res=>{
                    btn.style.color = '#ff0000';
                    btn.classList.toggle('check');
                    btn.children[1].innerHTML=`* ${res.goodCount}`;
                })
                .catch(error=>{
                    console.log(error);
                });
            }
        })
    })
})
