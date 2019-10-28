import { config, library, dom } from '@fortawesome/fontawesome-svg-core';

config.autoReplaceSvg = 'nest';

import {
    fas, faCaretUp, faCaretDown, faStar, faCheck
} from '@fortawesome/free-solid-svg-icons';

// Add custom icons to fontawesome library
library.add(fas, faCaretUp, faCaretDown, faStar, faCheck);

// Kicks off the process of finding <i> tags and replacing with <svg>
dom.watch();