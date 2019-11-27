import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import DealCard from './DealCard'
import Checkbox from './Checkbox'
import SquareAd from './SquareAd'
import Searched from './Searched'
import Subscribe from './Subscribe'
import SearchForm from './SearchForm'
import BrowseCard from './BrowseCard'
import PopularShops from './PopularShops'
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
  SquareAd,
  HasError,
  Searched,
  Subscribe,
  SearchForm,
  BrowseCard,
  AlertError,
  AlertSuccess,
  PopularShops,
  FeaturedCard,
  SearchOfferCard
].forEach(Component => {
  Vue.component(Component.name, Component)
})
