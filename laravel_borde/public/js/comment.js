window.addEventListener('load',function(){
    const goodBtn = document.querySelectorAll('.goodBtn');

    goodBtn.forEach(btn=>{
        btn.addEventListener('click',(e)=>{
            console.log(btn);
            e.preventDefault();
            const commentId = btn.dataset.comment_id;

            //押されている場合
            if(btn.classList.contains('check')){
                fetch(`/unlike/comment/${commentId}`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, // CSRFトークン対策

                })
                .then(response=>response.json())
                .then(res=>{
                    btn.style.color = '#000000';
                    btn.classList.toggle('check');
                    btn.children[1].innerHTML=`* ${res.goodCount}`;
                })
                .catch(error=>{
                    console.log(error);
                });
            }else{
                //urlにたいしてリクエストを送る
                fetch(`/like/comment/${commentId}`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, // CSRFトークン対策
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
