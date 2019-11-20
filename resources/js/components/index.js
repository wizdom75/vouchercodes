import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import DealCard from './DealCard'
import Checkbox from './Checkbox'
import Subscribe from './Subscribe'
import BrowseCard from './BrowseCard'
import FeaturedCard from './FeaturedCard'
import SearchOfferCard from './SearchOfferCard'
import {
  HasError,
  AlertError,
  AlertSuccess
} from 'vform'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  DealCard,
  Checkbox,
  HasError,
  Subscribe,
  BrowseCard,
  AlertError,
  AlertSuccess,
  FeaturedCard,
  SearchOfferCard
].forEach(Component => {
  Vue.component(Component.name, Component)
})
