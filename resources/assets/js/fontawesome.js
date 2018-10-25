import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';

import { faCaretUp } from '@fortawesome/free-solid-svg-icons/faCaretUp';

import { faCaretDown } from '@fortawesome/free-solid-svg-icons/faCaretDown';

import { faStar } from '@fortawesome/free-solid-svg-icons/faStar';

import { faCheck } from '@fortawesome/free-solid-svg-icons/faCheck';

// Add custom icons to fontawesome library
library.add(fas, faCaretUp, faCaretDown, faStar, faCheck);

// Kicks off the process of finding <i> tags and replacing with <svg>
dom.watch();