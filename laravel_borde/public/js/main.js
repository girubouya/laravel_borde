
window.addEventListener('load',function(){
        const goodBtn = document.querySelector('#goodBtn');
        const goodCount = this.document.querySelector('#goodCount');

        goodBtn.addEventListener('click',(e)=>{
            e.preventDefault();

            const postId = goodBtn.dataset.post_id; //選択されているPostIDを取得
            const data = {
                "dog":"犬",
                "cat":"猫",
            };

            //押されている場合
            if(goodBtn.classList.contains('check')){
                fetch(`/unlike/${postId}`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, // CSRFトークン対策

                })
                .then(response=>response.json())
                .then(res=>{
                    goodBtn.style.color = '#000000';
                    goodBtn.classList.toggle('check');
                    goodCount.innerHTML=`* ${res.goodCount}`;
                })
                .catch(error=>{
                    console.log(error);
                });
            }else{
                //urlにたいしてリクエストを送る
                fetch(`/like/${postId}`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json"}, // CSRFトークン対策
                    body:JSON.stringify(data),
                })
                .then(response=>response.json())
                .then(res=>{
                    goodBtn.style.color = '#ff0000';
                    goodBtn.classList.toggle('check');
                    goodCount.innerHTML=`* ${res.goodCount}`;
                    console.log(res.dog);
                })
                .catch(error=>{
                    console.log(error);
                });
            }
        })


})
