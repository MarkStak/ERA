function toggleMenu(menuId) {
    const menu = document.getElementById(menuId);
    const allMenus = document.querySelectorAll('.popup-menu');
    
    // Закрываем все открытые меню
    allMenus.forEach(m => {
      if (m.id !== menuId) {
        m.style.display = 'none';
      }
    });
    
    // Переключаем видимость выбранного меню
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  }
  
  // Закрытие меню при клике вне его области
  document.addEventListener('click', function(event) {
    const menus = document.querySelectorAll('.popup-menu');
    const buttons = document.querySelectorAll('.nav-btn');
    
    menus.forEach(menu => {
      let targetMenu = event.target.closest('.popup-menu');
      let targetButton = event.target.closest('.nav-btn');
      
      if (!targetMenu && !targetButton && menu.style.display === 'block') {
        menu.style.display = 'none';
      }
    });
  });