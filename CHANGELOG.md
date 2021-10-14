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
