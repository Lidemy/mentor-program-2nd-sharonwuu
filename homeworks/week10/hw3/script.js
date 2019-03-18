$(document).ready(function () {  
	let list = [
		{content:'item1',mark:0},
		{content:'<h1>item2</h1>',mark:1}
	] 
	render()

	function addTodo(todo) { 
		let inputArea = $('.row-addItem input')
		if( !inputArea.val() ){
			inputArea.attr('placeholder','I need a name for the item...');
		}else{
			list.push( {content:`${inputArea.val()}`,mark:0} )
			console.log(list)
	 		render( pageNow() )
		}
	}
	
	function removeTodo(id) {
	  list.splice(id, 1);  
	  render( pageNow() )
	}

	// 紀錄目前頁面，讓 render 前後停在同一頁 
	function pageNow(){
		if( $('.show-active').attr('class') ==='show-active show' ){
			return 'active'
		} //else 就是預設 all
	}

	function render(page){ //page 用來判斷顯示 all/active

		$('.row-addItem input').val('').attr('placeholder','What needs to be done?')
	  $('.listBlock').empty()
		$('nav > span').html(`${list.length} items left`)
	
		/* 先把 item 都列出來，再依照 page 判斷 要標記還是要隱藏 */
		list.map( (item,i) => {
			let itemContent = document.createTextNode( item.content )
			let area = `
					<div class="row-item" order="${i}">
						<div class="input-text"></div>
						<div class="btn-delete">－</div>
					</div>`
			$('.listBlock').append(area)
			$(`[order='${i}'] .input-text`).append(itemContent);

			if( item.mark ===1 && page === 'active'){
				//marked:display 
				$(`[order='${i}']`).css('display','none')
			}else if( item.mark ===1 &&  page !== 'active'){
				//marked:del
				$(`[order='${i}'] .input-text`).attr('mark','item-checked')
				$(`[order='${i}'] .input-text`).html(`<del></del>`)
				$(`[order='${i}'] del`).append(itemContent);
			}
		})

		// no active item
		if(page === 'active' && list.every(item => item.mark === 1) ){  
			$('.listBlock').append(`<div id="noItem"> No active item </div>`)
		}
		//no item
		if( page !== 'active' && list.length === 0 ){ 
			$('.listBlock').append(`<div id="noItem"> Add some items </div>`)
		}

		/* 舊的寫法：先判斷 page 再分別 append item
		if( page === 'active'){ 	
			$('.listBlock').append(list.map(
				(item,i) =>	{
					let content = document.createTextNode( item.content)
					if( item.mark === 0){
						return `
							<div class="row-item" order="${i}">
								<div class="input-text">${content}</div>
								<div class="btn-delete" >－</div>
							</div>`
					}else { //mark !=0 => display:none
						return `
							<div class="row-item" order="${i}" style="display:none;">
								<div class="input-text">${content}</div>
								<div class="btn-delete">－</div>
							</div>`					
					}
				}
			));

			// no active item
			if( list.every(item => item.mark === 1) ){  
				$('.listBlock').append(`<div id="noItem"> No active item </div>`)
			}
			
		}else{
			$('.listBlock').append(list.map(
				(item,i) =>	{
					let content = document.createTextNode( item.content)
					if( item.mark === 0){
						return `
							<div class="row-item" order="${i}">
								<div class="input-text">${content}</div>
								<div class="btn-delete">－</div>
							</div>`
					}else{ //mark !=0 => del content
						return `
							<div class="row-item" order="${i}">
								<div class="input-text" mark="item-checked"> 
									<del>${content}</del>
								</div>
								<div class="btn-delete">－</div>
							</div>`					
					}
				}
			));
			
			//no item
			if( list.length === 0 ){ 
				$('.listBlock').append(`<div id="noItem"> Add some items </div>`)
			}
		}
		*/	


	}


	/* add item */
	$('body').on('click', '#btn-add', addTodo);

	/* delete item */
	$('.listBlock').on('click', '.btn-delete', function(e){
		let order = $(e.target).parent().attr('order')		
		removeTodo(order)
	});

	/* change page */
	$('nav').on('click', 'span', function(e){ 
		if( $(e.target).attr('class') === 'show-active'){ 
			$('.show-all').attr('class' , 'show-all')
			$('.show-active').attr('class' , 'show-active show')
			render('active')

		}else if( $(e.target).attr('class') === 'show-all'){
			$('.show-all').attr('class' , 'show-all show')
			$('.show-active').attr('class' , 'show-active')
			render()
		}
	});

	/* mark item */
	$('.listBlock').on('click', '.input-text', function(e){
		let target = $(e.target)
		let index = target.parents('.row-item').attr('order')
		if( list[index].mark === 0 ){
			//未標記0 改為 已標記1
			list[index].mark = 1
		}else if( list[index].mark === 1){
			//已標記1 改為 未標記0
			list[index].mark = 0
		}
		render( pageNow() );
	});

});










