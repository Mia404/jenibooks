$(document).ready(function(){
    /* 전체보기 메뉴 */
    /* 카테고리 전체보기 마우스 오버 시 */
    $('.all-menu-category, .board-menu-div').hover(
        function(){
            $('.board-menu-div').css('visibility', 'visible');
        },
        function(){                    
            $('.board-menu-div').css('visibility', 'hidden');
        }
    );
    /* 전체보기 메뉴 */
    /* 카테고리 전체보기, X 아이콘 클릭 시  */
    $('.all-menu-category, .glyphicon-remove').click(function(){
        if($('.board-menu-div').css('visibility') == 'visible'){
            $('.board-menu-div').css('visibility', 'hidden');
        }else{
            $('.board-menu-div').css('visibility', 'visible');
        }
    });
});