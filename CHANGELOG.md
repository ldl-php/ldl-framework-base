# LDL Framework Base Changelog

All changes to this project are documented in this file.

This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [vx.x.x] - xxxx-xx-xx

### Added

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


### Changed

- fix/1200415270891779 - Fix array_walk from UnshiftInterfaceTrait
- fix/1200360444683565 - Remove extra brackets on UnshiftInterfaceTrait
- fix/1200327936147993 - Fix AppendableInterfaceTrait
- fix/1200271511926649 - Change collection traits names to comply with their contracts
- fix/1200099491334042 - Fix remove on RemovableInterfaceTrait - Add remove example - Add ArrayHelper
- fix/1200161406794549 - Fix KeyFilterInterface (and trait)
