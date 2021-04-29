import Vue from 'vue'
import {
  library
} from '@fortawesome/fontawesome-svg-core'
import {
  FontAwesomeIcon,
  FontAwesomeLayers,
  FontAwesomeLayersText
} from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
  faUser,
  faLock,
  faSignOutAlt,
  faCog,
  faSearch,
  faHeart,
  faEnvelope,
  faUpload,
  faTachometerAlt,
  faChartBar,
  faFolder,
  faStore,
  faTag,
  faFileAlt,
  faEdit,
  faTrash,
  faPlus,
  faUsers,
  faTags,
  faChartLine,
  faHandScissors,
  faCut,
  faPlug,
  faTools,
  faCheck,
  faAngleRight,
  faBolt

} from '@fortawesome/free-solid-svg-icons'
import {
  fab
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faSearch, fab, faHeart, faEnvelope, faUpload, faTachometerAlt, faChartBar, faFolder, faStore, faTag, faFileAlt, faEdit,
  faTrash, faPlus, faUsers, faTags, faChartLine, faHandScissors, faCut, faPlug, faTools, faCheck, faAngleRight,faBolt

)

Vue.component('fa', FontAwesomeIcon)
Vue.component('fal', FontAwesomeLayers)
Vue.component('falt', FontAwesomeLayersText)
