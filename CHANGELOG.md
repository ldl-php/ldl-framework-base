# LDL Framework Base Changelog

All changes to this project are documented in this file.

This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [vx.x.x] - xxxx-xx-xx

### Added

- feature/1200650274639165 - Add ClassFilter and InterfaceFilter helpers
- feature/1200385160035592 - Add filter recursive methods to class and interface collection traits
- feature/1200260135645241 - Add more collection contracts and traits
- feature/1200240987751220 - Add comparison operator helper (with constant names, etc)
- feature/1200197097272268 - Add implode method
- feature/1200195368152391 - Add toArray, map and filter to IterableHelper, add map and filter to CollectionInterface
- feature/1200175553157833 - Add iterable helper
- feature/1200136743167505 - Add properties modifiers to CollectionInterfaceTrait and fix ResetCollectionTrait
- feature/1200117701811978 - Add FilterByClassRecursive
- feature/1200099491334044 - Add FilterByInterfaceTrait and FilterByClassInterfaceTrait
- feature/1200103380811883 - Add \ArrayAccess to CollectionInterface
- feature/1200102901436033 - Create separate interfaces and traits for before append/replace/remove
- feature/1200094772219228 - Add locking condition checks to trait interfaces
- feature/1200082912582321 - Add Collection of Exceptions
- feature/1200082912582317 - Add Collection interfaces and traits
- feature/1200075065093231 - Add RegexHelper
- feature/1200030326491309 - Add ToArray and ArrayFactoryExceptions
- feature/1200005256502350 - Add ToArrayInterface and ArrayFactoryInterface
- feature/1199522825882943 - Add Symfony Var Dumper (https://github.com/symfony/var-dumper)
- feature/1200636482135423 - Enhance ComparisonOperatorHelper
- feature/1200836379007024 - Create MbEncodingHelper
- feature/1200836379007034 - Add getOppositeOperator to ComparisonOperatorHelper
- feature/1200767008358756 - Remove UnshiftInterface in favor of AppendInPositionInterface / Added KeyResolverCollection 
- feature/1200931458994855 - Add "callByRef" on CallableCollection (in which arguments are passed by reference)
- feature/1200942872266138 - Add HasValueResolverInterface
- feature/1201104104768447 - Add filterByValueType interface and trait (filters PHP types inside mixed collection)
- feature/1201127836211937 - Add unique and cast methods on IterableHelper. Add ComparisonInterface
- feature/1201194348713239 - Add LDL_TYPE_SCALAR and filterByValueType support in IterableHelper
- feature/1201194352686326 - Combine SingleSelection and MultipleSelection into Selection
- feature/1201226174735499 - Add object interface types add type support for IterableHelper::filterByValueTypes
- feature/1201243443283057 - All types must extend to LDLTypeInterface
- feature/1201243443283062 - Add __toString in ToStringInterface / Pass original items to IterableHelper::map
- feature/1201253503567912 - Add constants to type interfaces
- feature/1201278499056880 - Add $preserveKeys argument to IterableHelper::map (true by default)
- feature/1201329585503220 - IterableHelper::toArray takes in account ToArrayInterface
- feature/1200661351133652 - Separate sort interface and create SortInterfaceTrait
- feature/1201431627285833 - Add SPL like exceptions which extend to LDLException
- feature/1201422239594407 - Create AppendBeforeKey and AppendAfterKey trait and interface. Replace exceptions with LDL exceptions
- feature/1201432324634001 - Separate ksort() into SortBykeyInterface and SortBykeyInterfaceTrait
- feature/1201319260559916 - Add priority for CallableCollection with order and extract sorting functions into SortHelper class
- feature/1201438240911776 - Create LockSortInterface and LockSortInterfaceTrait. Throw Locking Exception if sort-locked
- feature/1201459659935193 - Separate Lock(Append/Remove/Replace/Sort/Selection)Exception so that they extend to LockingException
- feature/1201487027413413 - Add additional factory contracts (StringFactoryInterface, IntegerFactoryInterface, etc...)
- feature/1201487027413421 - Create FactoryInterface, every other factory must extend to this empty interface
- feature/1201513506354914 - ReflectionHelper::getClassesInFile, get class/interface/trait names out of a PHP as an array

### Changed

- fix/1200767008358756 - Improve traits. Fix autoincrement on Appendable. Add duplicate traits and helper
- fix/1200705568268975 - Fix AppendableInterfaceTrait
- fix/1200415270891779 - Fix array_walk from UnshiftInterfaceTrait
- fix/1200360444683565 - Remove extra brackets on UnshiftInterfaceTrait
- fix/1200327936147993 - Fix AppendableInterfaceTrait
- fix/1200271511926649 - Change collection traits names to comply with their contracts
- fix/1200099491334042 - Fix remove on RemovableInterfaceTrait - Add remove example - Add ArrayHelper
- fix/1200161406794549 - Fix KeyFilterInterface (and trait)
- fix/1200661351133647 - Clone objects when collection is locked
- fix/1200933785056563 - Remove Key word from resolvers collections and contracts
- fix/1200949376247310 - If collection is locked, and a CollectionInterface::get call is performed clone if object
- fix/1200949376247315 - Normalize remove methods into  RemoveByEqualValueInterface & RemoveByKeyInterface
- fix/1201029389120686 - Enhance IterableHelper, apply enhancements to traits
- fix/1201030058026867 - Fix removeByKey, decrease count when SEQ operator has been passed
- fix/1201047787762387 - Fix RemoveByKey to SEQ operator. Add getKeyInPosition in IterableHelper
- fix/1201136297126505 - Move all constants to a final class Constants
- fix/1200373038347536 - Fix validate from RegexHelper, it does not allow for flags such as: /test/i
- fix/1201136696237278 - Fix cast from IterableHelper to accept LDL types such as uint and udouble
- fix/1201177059252666 - Fix decimal and integer key resolvers
- fix/1201185659118458 - Remove strnum, switch for numeric (matches PHP is_numeric)
- fix/1201204612494306 - Fix unique from IterableHelper
- fix/1201234903595047 - Fix toArray from CollectionInterfaceTrait
- fix/1201352833985547 - When iterating on a collection and modifying the collection infinite recursion will happen
- fix/1201438240911772 - Add additional checks to sorting traits
- fix/1201487027413419 - Allow mixed return types for factory interfaces
- fix/1201519546203844 - ReflectionHelper::fromFile does not correctly parses namespaces
- fix/1201546068510508 - ReflectionHelper::fromFile adds empty trait/class/interfaces to returned array
- fix/1201509919633564 - Fix bad merge
- fix/1201546068510512 - ReflectionHelper::fromFile class parsing is incorrect
