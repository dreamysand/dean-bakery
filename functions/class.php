<?php
/**
 * 
 */
class Image
{
	function ImageUpload($file, $location, $url)
	{
		if (isset($file)) {
			if ($file['error'] == 0) {
				$allowed_Ext = [
					'jpg',
					'png',
					'jpeg',
					'gif',
					'jfif',
					'webp',
					'svg'
				];
				$target_Dir = $location;
				$img_Ext_Info = new SplFileInfo($file['name']);
				$img_Ext = $img_Ext_Info->getExtension();
				$new_File_Name = uniqid().".$img_Ext";
				$target_File = $target_Dir . $new_File_Name;
				$image_URL = $url . $new_File_Name;

				if (in_array($img_Ext, $allowed_Ext)) {
					if (move_uploaded_file($file['tmp_name'], $target_File)) {
						$img_Path = $target_File;
						$img_URL = $image_URL;
						$image_Array = [
							"url" => $img_URL,
							"path" => $img_Path
						];
						return $image_Array;
					} else {
						?>
						<script>
							console.log('Gambar gagal diupload');
						</script>
						<?php
						return null;
					}
				} else {
					?>
					<script>
						console.log('Ekstensi tidak didukung');
					</script>
					<?php
					return null;
				}
			}
		}
	}

	function ImagesUpload($file, $location)
	{
		$images = [];
		foreach ($file['name'] as $index => $name) {
			if (isset($file)) {
				if ($file['error'][$index] == 0) {
					$allowed_Ext = [
						'jpg',
						'png',
						'jpeg',
						'gif',
						'jfif',
						'webp',
						'svg'
					];
					$target_Dir = $location;
					$img_Ext_Info = new SplFileInfo($name);
					$img_Ext = $img_Ext_Info->getExtension();
					$new_File_Name = uniqid().".$img_Ext";
					$target_File = $target_Dir . $new_File_Name;

					if (in_array($img_Ext, $allowed_Ext)) {
						if (move_uploaded_file($file['tmp_name'][$index], $target_File)) {
							$images[] = $target_File;
						} else {
							?>
							<script>
								console.log('Gambar gagal diupload');
							</script>
							<?php 
						}
					} else {
						?>
						<script>
							console.log('Ekstensi tidak didukung');
						</script>
						<?php			
					}
				}
			}		
		}
		return $images;
	}

	function UpdateImage($file, $location, $url, $path_Image_Old, $URL_Image_Old)
	{
		$image_Array = [];
		if (empty($file['name'])) {
			$image_Array = [
				"url" => $URL_Image_Old,
				"path" => $path_Image_Old
			];
			return $image_Array;
		}

		if (file_exists($path_Image_Old)) {
			if (unlink($path_Image_Old)) {
				if ($file['error'] == 0) {
					$allowed_Ext = [
						'jpg',
						'png',
						'jpeg',
						'gif',
						'jfif',
						'webp',
						'svg'
					];
					$target_Dir = $location;
					$img_Ext_Info = new SplFileInfo($file['name']);
					$img_Ext = $img_Ext_Info->getExtension();
					$new_File_Name = uniqid().".$img_Ext";
					$target_File = $target_Dir . $new_File_Name;
					$image_URL = $url . $new_File_Name;

					if (in_array($img_Ext, $allowed_Ext)) {
						if (move_uploaded_file($file['tmp_name'], $target_File)) {
							$img_Path = $target_File;
							$img_URL = $image_URL;
							$image_Array = [
								"url" => $img_URL,
								"path" => $img_Path
							];
							return $image_Array;
						} else {
							return null;
						}
					} else {
						return null;
					}
				}
			} else {
				return null;
			}
		} else {
			return null;
		}
	}

	function DeleteImage($image)
	{
		if (file_exists($image)) {
			if (unlink($image)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
/**
 * 
 */
class Account
{
	private $id;
	private $email;
	private $username;
	private $password;
	private $gambar;

	function __construct($id = null, $email = null, $username = null, $password = null, $gambar = null)
	{
		$this->id = $id;
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;
		$this->gambar = $gambar;
	}

	function CheckEmail($email)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckAdminDuplication($email)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckAdminDuplicationUpdate($email, $id_Admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE email = :email
		AND id != :id_admin";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":email" => $email,
			":id_admin" => $id_Admin
		])) {
			if ($column = $stmt->fetchColumn()) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectAccount($email)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table
		WHERE email = :email";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":email" => $email
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddAdmin($email, $username, $password, $gambar)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
        (email
            ,username
            ,password
            ,gambar)
        VALUES (:email
            ,:username
            ,:password
            ,:gambar)";

        $stmt = $config->prepare($sql_Add_Query);
        if ($stmt->execute([
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':gambar' => $gambar,
        ])) {
            return true;
        } else {
            return false;
        }
        $stmt = null;
	}

	function HashPassword($password)
	{
		$algorythm1 = "md5";
		$algorythm2 = "sha256";
		$algorythm3 = "tiger192,4";
		$hash1 = hash($algorythm1, $password);
		$hash2 = hash($algorythm2, $hash1);
		$hash3 = hash($algorythm3, $hash2);

		return $hash3;
	}

	function PasswordVerify($password, $hashed_Password)
	{
		$algorythm1 = "md5";
		$algorythm2 = "sha256";
		$algorythm3 = "tiger192,4";
		$hash1 = hash($algorythm1, $password);
		$hash2 = hash($algorythm2, $hash1);
		$hash3 = hash($algorythm3, $hash2);

		if ($hash3 === $hashed_Password) {
			return true;
		} else {
			return false;
		}
	}

	function UpdateAdmin($id_admin, $email, $username, $gambar)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET 
		email = :email,
		username = :username,
		gambar = :gambar
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([
			":email" =>$email,
			":username" =>$username,
			":gambar" =>$gambar,
			":id_admin" =>$id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function GetAdminData()
	{
		$admin_Data = [
			"id" => $this->id,
			"email" => $this->email,
			"username" => $this->username,
			"password" => $this->password,
			"gambar" => $this->gambar
		];

		return $admin_Data;
	}

	function GetAdminsData()
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table";

		$stmt = $config->prepare($sql_Select_Query);		
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectAdmin($id_admin)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT *
		FROM $table
		WHERE
		id = :id_admin";

		$stmt = $config->prepare($sql_Select_Query);		
		if ($stmt->execute([
			"id_admin" => $id_admin
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		} else {
			return null;
		}
		$stmt = null;
	}

	function CheckStatusAdmin($id_admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($status['status'] == "Aktif") {
				$return_Value = [
					"msg" => "Admin saat ini sedang aktif",
					"value" => false 
				];
				return $return_Value;
			} elseif ($status['status'] == "Nonaktif") {
				$return_Value = [
					"value" => true 
				];
				return $return_Value;
			} else {
				$return_Value = [
					"msg" => "Fungsi gagal",
					"value" => false 
				];
				return $return_Value;
			}
		}
		$stmt = null;
	}

	function UpdateStatusAdmin($id_admin)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT status 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			$status = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt = null;
			if ($status['status'] == "Aktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id = :id_admin";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "Nonaktif",
					":id_admin" => $id_admin
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			} elseif ($status['status'] == "Nonaktif") {
				$sql_Update_Query = "UPDATE $table
				SET 
				status = :status
				WHERE id = :id_admin";

				$stmt = $config->prepare($sql_Update_Query);
				if ($stmt->execute([
					":status" => "Aktif",
					":id_admin" => $id_admin
				])) {
					$return_Value = [
						"value" => true 
					];
					return $return_Value;	
				} else {
					$return_Value = [
						"msg" => "Gagal memperbarui status",
						"value" => false 
					];
					return $return_Value;
				}
			} else {
				$return_Value = [
					"msg" => "Fungsi gagal",
					"value" => false 
				];
				return $return_Value;
			}
		}
		$stmt = null;
	}

	function DeleteAdmin($id_admin)
	{
		global $config, $table;
		$sql_Delete_Query = "DELETE 
		FROM $table
		WHERE id = :id";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":id" => $id_admin
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function GenerateToken($length = 32)
	{
		$token = bin2hex(random_bytes($length));

		return $token;
	}

	function InsertToken($id_admin, $token, $expired)
	{
		global $config, $table_token;
		$sql_Add_Query = "INSERT INTO
		$table_token 
		(id_admin,
			token,
			expired)
		VALUES
		(:id_admin,
			:token,
			:expired)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":id_admin" => $id_admin,
			":token" => $token,
			":expired" => $expired
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function CheckToken($token, $time)
	{
		global $config, $table_token;
		$sql_Check_Query = "SELECT COUNT(*) 
		FROM 
		$table_token
		WHERE
		token = :token
		AND
		expired > NOW()";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":token" => $token
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return true;
			} else {
				return false;
			}
		}
		$stmt = null;
	}

	function DeleteToken($token)
	{
		global $config, $table_token;
		$sql_Delete_Query = "DELETE FROM 
		$table_token
		WHERE
		token = :token";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":token" => $token
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Produk
{
	function CheckProduk($nama_produk)
	{
		global $config, $table_produk;
		$sql_Check_Query = "SELECT COUNT(*) 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckVarian($varian, $nama_produk)
	{
		global $config, $table_produk, $table_varian;
		$sql_Select_Query = "SELECT id_produk 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			if ($produk = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt = null;
				$id_Produk = $produk['id_produk'];

				$sql_Check_Query = "SELECT COUNT(*)
				FROM $table_varian
				WHERE
				varian = :varian
				AND
				fid_produk = :id_produk";

				$stmt = $config->prepare($sql_Check_Query);
				if ($stmt->execute([
					":varian" => $varian,
					":id_produk" => $id_Produk
				])) {
					$column = $stmt->fetchColumn();
					if ($column > 0) {
						return $column;
					} else {
						return null;
					}
				}
			}
		}
		$stmt = null;
	}

	function SelectProduks()
	{
		global $config, $table_produk;
		$sql_Select_Query = "SELECT * FROM $table_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			$result_Produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result_Produk;
		} else {
			return null;
		}
	}

	function SelectProduk($id_produk)
	{
		global $config, $table_produk;
		$sql_Select_Query = "SELECT * FROM $table_produk WHERE fid_produk = :id_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_produk" => $id_produk
		])) {
			$result_Produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result_Produk;
		} else {
			return null;
		}
		$stmt = null;
	}

	function SelectVarian($id_produk)
	{
		global $config, $table_varian;
		$sql_Select_Query = "SELECT * FROM $table_varian WHERE fid_produk = :id_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_produk" => $id_produk
		])) {
			$result_Varian = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result_Varian;
		} else {
			return null;
		}
		$stmt = null;
	}

	function AddProduk($nama_produk, $id_kategori, $deskripsi)
	{
		global $config, $table_produk;
		$sql_Add_Query = "INSERT INTO $table_produk
		(nama_produk,
			fid_kategori,
			deskripsi)
		VALUES
		(:nama_produk,
			:id_kategori,
			:deskripsi)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk,
			"id_kategori" => $id_kategori,
			":deskripsi" => $deskripsi
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function AddVarian($nama_produk, $varian, $tanggal_expired, $stok, $modal, $harga_jual, $keuntungan, $gambar)
	{
		global $config, $table_produk, $table_varian;
		$sql_Select_Query = "SELECT id_produk 
		FROM $table_produk
		WHERE
		nama_produk = :nama_produk";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":nama_produk" => $nama_produk
		])) {
			if ($produk = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$stmt = null;
				$id_produk = $produk['id_produk'];

				$sql_Add_Query = "INSERT INTO $table_varian
				(fid_produk,
					varian,
					tanggal_expired,
					stok,
					modal,
					harga_jual,
					keuntungan,
					gambar)
				VALUES
				(:id_produk,
					:varian,
					:tanggal_expired,
					:stok,
					:modal,
					:harga_jual,
					:keuntungan,
					:gambar)";

				$stmt = $config->prepare($sql_Add_Query);
				if ($stmt->execute([
					":id_produk" => $id_produk,
					"varian" => $varian,
					"tanggal_expired" => $tanggal_expired,
					"stok" => $stok,
					"modal" => $modal,
					"harga_jual" => $harga_jual,
					"keuntungan" => $keuntungan,
					":gambar" => $gambar
				])) {
					return true;
				} else {
					return false;
				}
			}
		}
		$stmt = null;
	}

	function UpdateProduk($value='')
	{
		// code...
	}

	function UpdateVarian($value='')
	{
		// code...
	}
}
/**
 * 
 */
class Kategori
{
	
	function CheckKategori($kategori)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		kategori = :kategori";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":kategori" => $kategori
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckKategoriUpdate($kategori, $id_kategori)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		kategori = :kategori
		AND
		id_kategori != :id_kategori";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":kategori" => $kategori,
			":id_kategori" => $id_kategori
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddKategori($kategori, $gambar)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
		(kategori, 
			gambar)
		VALUES
		(:kategori, 
			:gambar)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":kategori" => $kategori,
			":gambar" => $gambar
		])) {
			return true;
		} else {
			return false;
		}
	}

	function SelectKategori($id_kategori)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM
		$table
		WHERE
		id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_kategori" => $id_kategori
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectKategoris()
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM $table";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function UpdateKategori($kategori, $gambar, $id_kategori)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET
		kategori = :kategori,
		gambar = :gambar
		WHERE
		id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([ 
			"kategori" => $kategori,
			"gambar" => $gambar,
			$id_kategori => $id_kategori
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function DeleteKategori($id_kategori)
	{
		global $config, $table;
		$sql_Delete_Query = "DELETE 
		FROM $table
		WHERE id_kategori = :id_kategori";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":id_kategori" => $id_kategori
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Member
{
	
	function CheckMember($no_telp)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		no_telp = :no_telp";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":no_telp" => $no_telp
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function CheckMemberUpdate($no_telp, $id_member)
	{
		global $config, $table;
		$sql_Check_Query = "SELECT COUNT(*)
		FROM $table
		WHERE
		no_telp = :no_telp
		AND
		id_member != :id_member";

		$stmt = $config->prepare($sql_Check_Query);
		if ($stmt->execute([
			":no_telp" => $no_telp,
			":id_member" => $id_member
		])) {
			$column = $stmt->fetchColumn();
			if ($column > 0) {
				return $column;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function AddMember($nama, $no_telp)
	{
		global $config, $table;
		$sql_Add_Query = "INSERT INTO $table
		(nama, no_telp)
		VALUES
		(:nama, :no_telp)";

		$stmt = $config->prepare($sql_Add_Query);
		if ($stmt->execute([
			":nama" => $nama,
			":no_telp" => $no_telp
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function SelectMember($id_member)
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM
		$table
		WHERE
		id_member = :id_member";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute([
			":id_member" => $id_member
		])) {
			if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function SelectMembers()
	{
		global $config, $table;
		$sql_Select_Query = "SELECT * FROM $table";

		$stmt = $config->prepare($sql_Select_Query);
		if ($stmt->execute()) {
			if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
				return $result;
			} else {
				return null;
			}
		}
		$stmt = null;
	}

	function UpdateMember($nama, $no_telp, $id_member)
	{
		global $config, $table;
		$sql_Update_Query = "UPDATE $table
		SET
		nama = :nama,
		no_telp = :no_telp
		WHERE
		id_member = :id_member";

		$stmt = $config->prepare($sql_Update_Query);
		if ($stmt->execute([ 
			"nama" => $nama,
			"no_telp" => $no_telp,
			$id_member => $id_member
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}

	function DeleteMember($id_member)
	{
		global $config, $table;
		$sql_Delete_Query = "DELETE 
		FROM $table
		WHERE id_member = :id_member";

		$stmt = $config->prepare($sql_Delete_Query);
		if ($stmt->execute([
			":id_member" => $id_member
		])) {
			return true;
		} else {
			return false;
		}
		$stmt = null;
	}
}
/**
 * 
 */
class Cart
{
	public array $cart = [];

	function __construct()
	{
		$this->cart = [];
	}

	function AddItems($id_produk, $id_varian, $nama_produk, $varian, $harga_jual, $jumlah, $tanggal_expired, $gambar)
	{
		if (!isset($this->cart[$id_produk])) {
			$this->cart[$id_produk] = [];
		}

		if (isset($this->cart[$id_produk][$id_varian])) {
			$this->cart[$id_produk][$id_varian]["jumlah"] += $jumlah;
		} else {
			$this->cart[$id_produk][$id_varian] = [
				"id_produk" => $id_produk,
				"id_varian" => $id_varian,
				"nama_produk" => $nama_produk,
				"varian" => $varian,
				"harga_jual" => $harga_jual,
				"jumlah" => $jumlah,
				"tanggal_expired" => $tanggal_expired,
				"gambar" => $gambar
			];
		}
		return isset($this->cart[$id_produk][$id_varian]);
	}

	function GetItems()
	{
		return $this->cart;
	}

	function DeleteItems($id_produk, $id_varian)
	{
		if (isset($this->cart[$id_produk][$id_varian])) {
			unset($this->cart[$id_produk][$id_varian]);
			if (empty($this->cart[$id_produk])) {
				unset($this->cart[$id_produk]);
			}	
		}
	}

	function DeleteAllItems()
	{
		if (isset($this->cart)) {
			unset($this->cart);
		}
	}
}
?>