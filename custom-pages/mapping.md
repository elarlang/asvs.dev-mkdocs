# Mapping between v4.0.3 and v5.0.0

For a smooth transfer from ASVS v4.0.3 to v5.0.0, it is good to know:

  * What happened with a particular requirement since v4.0.3?
  * Does a requirement in v5.0.0 originate from requirement/s from v4.0.3, or is it completely new?

Through the 3.5 years between releases v4.0.3 and v5.0.0, all changes were tracked and tagged to make it possible to provide a 2-way mapping.

Mappings are presented in separate `yml` files. However, a formatted output is also provided on asvs.dev:

  * Mapping from **v4.0.3 to v5.0.0**:
    * <https://github.com/OWASP/ASVS/tree/v5.0.0/5.0/mappings/mapping_v4.0.3_to_v5.0.0.yml> - mapping file
    * <https://asvs.dev/mapping_v4.0.3_to_v5.0.0.html> - visual overview of changes
  * Mapping from **v5.0.0 to v4.0.3**:
    * <https://github.com/OWASP/ASVS/tree/v5.0.0/5.0/mappings/mapping_v5.0.0_to_v4.0.3.yml> - mapping file
    * <https://asvs.dev/mapping_v5.0.0_to_v4.0.3.html> - visual overview of changes

Tags in new (v5.0.0) mapping file:

  * `ADDED` - new requirement
  * `MOVED FROM x.y.z` - reference to the requirement number from v4.0.3. Must have a matching `MOVE TO` tag in the old mapping file.
    * `GRAMMAR` - indicates that there are grammar or language corrections in the moved requirement, which don't change the requirement's meaning.
    * `MODIFIED` - indicates that the meaning of the moved requirement was changed (more than just a language or grammar change).
  * `SPLIT FROM x.y.z` - the v4.0.3 requirement was split to multiple requirements in v5.0.0. Must have a matching `SPLIT TO` in the old mapping file.
  * `MERGED FROM x.y.z` - the v4.0.3 requirement has been merged with another requirement for v5.0.0. Must have a matching `MERGED TO` tag in the old mapping file.
  * `COVERS x.y.z` - the v5.0.0 requirement covers the content of this v4.0.3 requirement. Must have a matching `COVERED BY x.y.z` tag in the old mapping file.

Tags in old (v4.0.3) mapping file:

  * `DELETED` - the v4.0.3 requirement is deleted in the new version, with a reason.
    * `DELETED, NOT IN SCOPE` - requirement has been decided to be out of the redefined scope of ASVS.
    * `DELETED, INCORRECT` - requirement was invalid or provided inadvisable advice.
    * `DELETED, NOT PRACTICAL` - the requirement was not practical (enough) to implement in reality.
    * `DELETED, INSUFFICIENT IMPACT` - the requirement provided insufficient benefit to be worthwhile.
    * `DELETED, MERGED TO x.y.z` - the requirement was merged to another requirement for v5.0.0. Must have a matching `MERGED FROM` tag in the new mapping file.
    * `DELETED, COVERED BY x.y.z` - the requirement was a duplicate of or is covered by another requirement in v5.0.0. Must have a matching `COVERS` tag in the new mapping file.
  * `MOVED TO x.y.z` - reference to the requirement number from v5.0.0. Must have a matching `MOVED FROM` tag in the new version
  * `SPLIT TO x.y.z, i.j.k` - the v4.0.3 requirement is divided into multiple requirements in v5.0.0. Must have matching `SPLIT FROM` tags in the new mapping file.
