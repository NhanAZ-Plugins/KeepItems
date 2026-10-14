# KeepItems

KeepItems is a legacy inventory-retention plugin ported to Axolotl-PM API 5.0.0. When `KeepInventory` is enabled, it sets `PlayerDeathEvent::setKeepInventory(true)`. When disabled, it leaves the event unchanged so other plugins can make their own decision.

The existing configuration keys remain supported: `KeepInventory`, `MessageAfterDeath`, `MessageToPlayerAfterDeath`, `MessageType`, and `Notices`. Invalid values use documented defaults. Message types are `message`, `popup`, `tip`, `title`, `subtitle`, and `actionbarmessage`.

This repository is archived and is no longer the maintained inventory-retention plugin. The maintained successor is [KeepInventory](https://github.com/NhanAZ-Plugins/KeepInventory); its configuration and behavior are different, so review its [configuration guide](https://github.com/NhanAZ-Plugins/KeepInventory#configuration-and-behavior) before switching. KeepItems retains the original [GPL-3.0 license](LICENSE) and NhanAZ authorship. No new stable release is published for this retired successor project.

CI runs PHPStan at maximum level and builds and inspects the PHAR against pinned Axolotl-PM 5.0.0 and 5.49.1 source revisions. It also starts the built plugin on Axolotl-PM 5.49.1. These checks verify the tested points, not every 5.x release. No connected-player death flow was tested.
