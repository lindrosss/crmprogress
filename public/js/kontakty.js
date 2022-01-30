

var myMap;
        
    ymaps.ready(function(){
        myMap = new ymaps.Map("myMap", {
            center: [56.2936668993494,43.948630373016286],
            zoom: 13
        });
		
		myPlacemark = new ymaps.Placemark([56.2936668993494,43.948630373016286], {
                hintContent: 'Мы тут!',
                balloonContent: 'Столица России'
            });
            
            myMap.geoObjects.add(myPlacemark);
			myMap.controls.add('mapTools');
			myMap.controls.add('zoomControl');
       
    });		
		