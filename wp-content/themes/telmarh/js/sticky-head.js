// Set options
        if ( jQuery('.site-header').size() > 0 ){
        var options = {
            offset: 200,
            classes: {
                clone:   'banner--clone',
                stick:   'banner--stick',
                unstick: 'banner--unstick'
            }
        };

            // Initialise with options
            var banner = new Headhesive('.site-header', options);

        }


        // Headhesive destroy
        // banner.destroy(); 